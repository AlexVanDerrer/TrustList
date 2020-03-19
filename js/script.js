/**
 * Базовый домен
 */
const base_url = 'http://cu26250.tmweb.ru/';
/**
 * ID Приложения ВК
 */
const apiId = 7326195;
/**
 * Числовая маска запроса доступа к данным пользователя 
 * (notify, friends, photos, status, offline, email)
 * 1 + 2 + 4 + 1024 + 65536 + 419430 = 4260871
 */
const fields = 4260871; 

$(function(){
	VK.init({ apiId: apiId, status: true });

    //клик по кнопке авторизоваться ВК
    $('#auth').on('click', function() {
		
        VK.Auth.login(function(response) {
            if (response.session) {
				var user = response.session.user;
				var email = !user.email ?  null : user.email;
				//отправляем информацию ajax post в backend
				//для проверки и при необходимости
				//добавление в базу данных
				sendAjaxPostUser(user.id, user.href, email, user.domain);
				// Получаем друзей пользователя
				getUserFriends(user.id);
				//после отправки -> редирект на базовую страницу
				
            } else {
              	console.log("error login");
            }
		}, 
		fields ); 
	});
	
    //клик по кнопке Войти (login_view)
    $('#login-btn').on('click', function(e) {
        e.preventDefault();
        var login = $('input[name="authLogin"]').val();
        var password = $('input[name="authPassword"]').val();
        $.ajax({
			type:"POST",
			url: base_url+"backend/auth_user",
			dataType: 'json',
			data:
			{
				'action': 'user_login',
				'login': login,
				'password': password
			},
         	success: function(data){
				if(data.status){
					console.log('auth ok');
					document.location.href = base_url;
				} else {
					$('#error_msg').removeClass('d-none').text(data.message);
				}
          	}  
        });
    })

    // клик по кнопке Выйти
    $('#logout').on('click', function(){
		$.ajax({
			type:"GET",
			url: base_url+"backend/ses_destroy",
			dataType: 'json',
			data:
			{
				'logout': 'exit',
			},
			success: function(data){
				if(data.status){
					document.location.href = base_url;
				} else {
					console.log(data.message);
					// $('#error_msg').removeClass('d-none').text(data.message);
				}
			}  
		});
	})

	// клик по кнопке Добавить пользователя
	$('#addNewUser').on('click', function(){
		var formData = new FormData;
		formData.append('id', $('input[name="userId"]').val());
        formData.append('fname', $('input[name="addFname"]').val());
        formData.append('lname', $('input[name="addLname"]').val());
        formData.append('scope', $('input[name="addScope"]').val());
        formData.append('position', $('input[name="addPosition"]').val());
        formData.append('mphone', $('input[name="addMphone"]').val());
		formData.append('city', $('input[name="addCity"]').val());
		formData.append('href', $('input[name="addHref"]').val());
		
        var file = $('#addPhoto');
        if (file.prop('files').length) {
            formData.append('image', file.prop('files')[0]);

        } else {
            console.log("Не выбран файл для загрузки!");
        }
        $.ajax({
            url: base_url+"backend/add_new_user",
            data: formData,
            processData: false,
            contentType: false,
			type: 'POST',
			dataType: "json",
            success: function(data) {
				if (data.status){
					$('#error_msg').addClass('alert alert-success').removeClass('d-none').text(data.message);
					setTimeout(function(){
						document.location.href = base_url;
					}, 500)
				} else {
					$('#error_msg').addClass('alert alert-danger').removeClass('d-none').text(data.message);
				}		
            }
        });

	})
	// клик по кнопке Продолжить
	$('#btn_form_success').on('click', function(e){
		e.preventDefault();
        var login = $('input[name="login"]').val();
        var password = $('input[name="password"]').val();
        $.ajax({
			type:"POST",
			url: base_url+"backend/auth_user",
			dataType: 'json',
			data:
			{
				'action': 'user_login',
				'login': login,
				'password': password
			},
         	success: function(data){
				if(data.status){
					console.log('auth ok');
					document.location.href = base_url;
				} else {
					$('#error_msg').removeClass('d-none').text(data.message);
				}
          	} 
        });
	})
	// Превью аватарки

	let imgPrev = document.getElementById('image-preview'),
		uploadImg = document.getElementById('addPhoto'),
		btDel = document.getElementById('delete-link');
	const addImg =  function(){ 
		imgPrev.src = URL.createObjectURL(event.target.files[0])
	};
	const delImg = function() {
		uploadImg.value = imgPrev.src = base_url+'img/foto.jpg';
		URL.revokeObjectURL(imgPrev.src);
	};
	uploadImg.addEventListener('change',addImg);
	// btDel.addEventListener('click',delImg);
	
	// Живой ПОИСК
	var $result = $('#search_box-result');
	
	$('#search').on('keyup', function(){
		var search = $(this).val();
		if ((search != '') && (search.length > 1)){
			$.ajax({
				type: "POST",
				url: base_url+"backend/ajax_search",
				data: {'search': search},
				success: function(msg){
					$result.html(msg);
					if(msg != ''){	
						$result.fadeIn();
					} else {
						$result.fadeOut(100);
					}
				}
			});
		} else {
			$result.html('');
			$result.fadeOut(100);
		}
	});
 
	$(document).on('click', function(e){
		if (!$(e.target).closest('.search_box').length){
			$result.html('');
			$result.fadeOut(100);
		}
	});


})
/**********************************************************************/

/**
 * получение информации о пользователе ВК,
 * отправляем информацию ajax post в backend/auth_user_vk
 * @param {number} id 
 * @param {string} href 
 * @param {string} email 
 * @param {string} domain 
 */
function sendAjaxPostUser(id, href, email , domain)
{
  VK.Api.call('users.get', {
    'user_ids': id, 
    'fields':  'photo_100, contacts, email', 
    'v':"5.89"}, 
	function(data) {
		if(data.response) {
			$.ajax({
				url: base_url+"backend/auth_user_vk",
				type:"post",
				data:
				{
					'action': 'get_user',
					'user_id': data.response[0].id,
					'fname': data.response[0].first_name,
					'lname': data.response[0].last_name,
					'mphone': data.response[0].mobile_phone,
					'hphone': data.response[0].home_phone,
					'photo_url': data.response[0].photo_100,
					'href': href,
					'email': email,
					'domain': domain
				},
				dataType: "json",
				success: function(data){
					if(data.status){
						console.log(data.status);
						document.location.href = base_url;
					} else {
						console.log(data.message);
						// $('#error_msg').removeClass('d-none').text(data.message);
					}
				}
			});

  		}	
  	});
}
/**
 * Получаем список друзей пользователя
 * и отправляем в backend/get_user_friends
 * @param {number} uid 
 */
function getUserFriends(uid){
	VK.Api.call('friends.get', 
	{ 
		user_ids: uid, 
		fields: 'career, sex, bdate, city, country, photo_100, has_mobile, contacts, education, online, relation, last_seen, status, can_write_private_message, can_see_all_posts, can_post, universities, domain ', 
		count: 5000, v:"5.103"
	}, 
	function(r) {
		if(r.response) {
			friends = r.response;
			$.ajax({
				type:"POST",
				url: base_url+'backend/get_user_friends',
				data:
				{
					'action':'list_friend',
					'user_uid': uid,
					'friends': friends.items
				},
				success:function(data){
					console.log(data.message);
				}
			});
		}
	});
}

function delContact(id){
	var resp = confirm("Вы дейсвительно хотите удалить данный контакт из списка?");
	if (resp == true) {
		$.ajax({
			type:"POST",
			url: base_url+'backend/del_contact_from_list',
			data:
			{
				'action':'del_contact',
				'contact_id': id
			},
			dataType: "json",
			success:function(data){
				if(data.status){
					console.log(data.message);
					$('#message').addClass('alert alert-success ').removeClass('d-none').text(data.message);
					document.location.href = base_url;
				} else {
					console.log(data.message);
					$('#message').addClass('alert alert-danger ').removeClass('d-none').text(data.message);
				}
			}
		});

	} else {
		$('#message').addClass('alert alert-danger ').removeClass('d-none').text("Отмена! Контакт не удален!");
		setTimeout(function(){
			document.location.href = base_url;
		}, 300)
	}
}

function editContact(id){
	$('#edit-modal-form').removeClass('d-none');
	$('.close').on('click', function(){ $('#edit-modal-form').addClass('d-none');})
	$('#saveDataContact').on('click', function(){
		var formData = new FormData;
		formData.append('id', id);
		formData.append('fname', $('input[name="editFname"]').val())
		formData.append('lname', $('input[name="editLname"]').val());
		formData.append('scope', $('input[name="editScope"]').val());
		formData.append('position', $('input[name="editPosition"]').val());
		formData.append('mphone', $('input[name="editMphone"]').val());
		formData.append('email', $('input[name="editEmail"]').val());
		formData.append('city', $('input[name="editCity"]').val());
		formData.append('href', $('input[name="editHref"]').val());
		
		$.ajax({
			url: base_url+"backend/edit_contact",
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType: "json",
			success: function(data){
				if (data.status){
					console.log(data);
					$('#callback_message').addClass('alert alert-success').removeClass('d-none').text(data.message);
					setTimeout(function(){
						document.location.href = base_url;
					}, 500)
				} else {
					$('#callback_message').addClass('alert alert-danger').removeClass('d-none').text(data.message);
				}	
			}
		});
	})
}

function addComment(id){
	$('#add-comment-form').removeClass('d-none');
	$('.close').on('click', function(){ $('#add-comment-form').addClass('d-none');})
	$('#saveComment').on('click', function(){
		var formData = new FormData;
		formData.append('id', id);
		formData.append('comment', $('input[name="addNewComment"]').val())

		$.ajax({
			url: base_url+"backend/add_comment_contact",
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType: "json",
			success: function(data){
				if (data.status){
					console.log(data);
					$('#comment_callback_message').addClass('alert alert-success').removeClass('d-none').text(data.message);
					setTimeout(function(){
						document.location.href = base_url;
					}, 500)
				} else {
					$('#comment_callback_message').addClass('alert alert-danger').removeClass('d-none').text(data.message);
				}
			}
		});
	})
}