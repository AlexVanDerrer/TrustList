<?php 
// ШАБЛОН КОНТАКТА ИЗ РЕКОМЕНДАЦИЙ 
if ($photo_url == '') $photo_url = 'http://cu26250.tmweb.ru/img/foto.jpg';
if ($fname == '' && $lname == '') { $full_name = $user_login; } else { $full_name = $fname.' '.$lname; }
?>


<div class="container one-contact br-20">
    <div class="row p-1">
        <div class=" relative">
            <div class="control-btn-left-bottom absolute">
                <a id="comment-contact" class="text-decoration-none" title="Добавить комментарий" onClick="comment_rec_contact(<?=$id?>)">
                    <img class="control-btn" src="img/comment.png" alt="" sizes="10" srcset="">
                </a>
            </div>  
        </div>
        <div class="col-1 p-0" ><img src="<?=$photo_url; ?>" class="avatar" alt="" title="Комментарий"></img></div>
        <div class="col align-self-center"> <?=$full_name?></div>
        <div class="col align-self-center"><?=$email?><br> <?=$mphone;?></div>
        <div class="col align-self-center"><?=$city;?></div>
        <div class="col align-self-center"><?=$scope;?></div>
        <div class="col align-self-center"><?=$position;?></div>
        <div class="relative">
                <div class="control-btn-right-top absolute">
                        <a id="edit-contact" class="text-decoration-none" title="Редактировать" onClick="delContact(<?=$id?>)">
                            <img class="control-btn" src="img/edit.png" alt="" sizes="10" srcset="">
                        </a>
                    </div> 
                    <div class="control-btn-right-center absolute">
                        <?php if ($href != null && $href != '') :?>
                            <a class="text-light" href="<?=$href?>" title="страница ВК">
                                <i class="fa fa-vk" aria-hidden="true"></i>
                            </a>
                        <?php else : ?>
                            <a class="text-light" href="" title="страница ВК">
                                <i class="fa fa-vk" aria-hidden="true"></i>
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="control-btn-right-bottom absolute">
                        <a id="del-contact" class="text-decoration-none" title="Удалить из списка" onClick="delContact(<?=$id?>)">
                            <img class="control-btn" src="img/delete.png" alt="" sizes="10" srcset="">
                        </a>
                    </div>  
                </div>
        
    </div>
</div>