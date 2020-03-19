<?php
if ($count%10 == 1 ) {
    $suff = '';  
} 
elseif ($count%10 == 0 || $count%10 >= 5 ) {
    $suff = 'ов';
}
elseif($count%10 > 1 || $count%10 < 5) {
    $suff = 'а';
} 
?>
<?php if (isset($user['error'])) :?>
    <h1 class='text-white'>Ошибка данных</h1>
<?php else : ?>
<?php if($direction == "ASC") {$caret = '<i class="fa fa-caret-down" aria-hidden="true"></i>'; $title_link = "обратном алфавитном";}
        else {$caret = '<i class="fa fa-caret-up" aria-hidden="true"></i>'; $title_link = "алфавитном"; } ?>


<div id="logout" class="mx-auto">
    <i class="fa fa-sign-out" aria-hidden="true" title="Выход"></i>
</div>
<div id="search" class="mx-auto" onClick="search_by_contacts(<?=$user['id']?>)">
    <i class="fa fa-search" aria-hidden="true" title="Поиск"></i>
</div>


<div class="container mx-auto text-center align-self-center">
    <div class="row">
        <div class="col">
            <h1 class='text-white'>Список доверия</h1>

            <?php if(isset($user['id'])) : ?> 
                <div class="count-users">
                    <p class="m-0"><?=$title_name = ($user['fname']) ? $user['fname'] : $user['user_login'] ;?></p>
                    <p><?=$count;?> контакт<?=$suff?> <span>(<?=$count_vk?> из Вконтакте)</span></p>
                </div>
                <div id="message" class="d-none"></div>

                <div class="search_box mx-auto br-20">
                    
                        <input type="text" name="search" id="search" placeholder="Поиск">
                        <input type="submit">			
                   
                    <div id="search_box-result"></div>
                </div>
                <?php if(count($search_arr) > 0) : ?> 
                    <div class="resault-friend">
                    <table id="" class='user-contact-table'>
                        <thead>
                            <tr>
                                <th id="rating"></th>
                                <th id="ava"></th>
                                <th id="name"><a href="?column=fname&direction=<?=$direction?>" title="Сортировать в <?=$title_link?> порядке">Имя </a><?=$caret?></th>
                                <th id="contact">Контакты</th>
                                <th id="city">Город</th>
                                <th id="scope">Область деятельности</th>
                                <th id="position"><a href="?column=position&direction=<?=$direction?>" title="Сортировать в <?=$title_link?> порядке">Должность </a><?=$caret?></th>
                                <th id="link"></th>
                            </tr>
                        </thead>
                        </table>
                            <?php foreach($search_arr as $value) : ?>
                                <?php $this->load->view('contact_tmp', $value);?>
                            <?php endforeach ?>
                </div> 
                <?php else : ?> 
                <div class="resault-friend">
                    <table id="" class='user-contact-table'>
                        <thead>
                            <tr>
                                <th id="rating"></th>
                                <th id="ava"></th>
                                <th id="name"><a href="?column=fname&direction=<?=$direction?>" title="Сортировать в <?=$title_link?> порядке">Имя </a><?=$caret?></th>
                                <th id="contact">Контакты</th>
                                <th id="city">Город</th>
                                <th id="scope">Область деятельности</th>
                                <th id="position"><a href="?column=position&direction=<?=$direction?>" title="Сортировать в <?=$title_link?> порядке">Должность </a><?=$caret?></th>
                                <th id="link"></th>
                            </tr>
                        </thead>
                        </table>
                        
                            <?php if($count > 0) :?>
                                <?php foreach($contacts as $value) : ?>
                                    <?php $this->load->view('contact_tmp', $value);?>
                                <?php endforeach ?>

                            <?php endif ?>
                </div>
                <?php endif ?>


            <?php endif ?>
                <!-- Button Modal -->
                <button id="btn_add_friend" class='btn btn-outline-light br-20 mt-3' data-toggle="modal" data-target="#exampleModalCenter">Добавить пользователя + </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewContact">Добавление нового пользователя</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id='form-add-new-user'>
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                    <div class="form-group">
                                        <input type="hidden" name="userId" value="<?=$user['id']?>">
                                        <input name="addFname" type="text" class="form-control br-20 mx-auto" id="addFname" placeholder="Имя">
                                        </div>
                                        <div class="form-group">
                                            <input name="addLname" type="text" class="form-control br-20 mx-auto" id="addLname" placeholder="Фамилия">
                                        </div>
                                        <div class="form-group">
                                            <input name="addScope" type="text" class="form-control br-20 mx-auto" id="addScope" placeholder="Область деятельности">
                                        </div>
                                        <div class="form-group">
                                            <input name="addPosition" type="text" class="form-control br-20 mx-auto" id="addPosition" placeholder="Должность">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    <div class="form-group">
                                            <input name="addMphone" type="text" class="form-control br-20 mx-auto" id="addMphone" placeholder="Телефон">
                                        </div>
                                        <div class="form-group">
                                            <input name="addCity" type="text" class="form-control br-20 mx-auto" id="addCity" placeholder="Город">
                                        </div>
                                        <div class="form-group">
                                            <input name="addHref" type="text" class="form-control br-20 mx-auto" id="addHref" placeholder="Страница ВКонтакте">
                                        </div>
                                        
                                        <label>
                                            <img id="image-preview" src="http://cu26250.tmweb.ru/img/foto.jpg"  height="100" width="100" alt="Нажмите для выбора файла" class="br-20">
                                            <input name="addPhoto" type="file" id="addPhoto" hidden>
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <p id='error_msg' class='d-none'></p>
                        </form>

                        </div>
                        <div class="modal-footer">
                            <button id="addNewUser" type="button" class="btn btn-primary br-20 mx-auto">Добавить</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- end Modal -->

           

        </div>
    </div>
    <?php
    /**
     * Блок с рекомендациями контактов для пользователя
     * друзья-друзей, рекламные и т.д.
     * в вид передается массив из таблицы recomendations
     */
    ?>
    <?php if(count($recomendations)  > 0) :?>
    <div class="row">
        <div class="col">
            <div class="recomendations">
                <h5 class='text-white mt-3'>Возможно вы знакомы</h5>

                <div class="resault-recomendations">
                    <table id="" class='user-contact-table'>
                        <thead>
                            <tr>
                                <th id="rating"></th>
                                <th id="ava"></th>
                                <th id="name"><a href="home/?column=fname&direction=ASC">Имя</a> </th>
                                <th id="contact">Контакты</th>
                                <th id="city">Город</th>
                                <th id="scope">Область деятельности</th>
                                <th id="position"><a href="home/?column=position&direction=ASC">Должность</a></th>
                                <th id="link"></th>
                            </tr>
                        </thead>
                        </table>

                                <?php foreach($recomendations as $value) : ?>
                                    <?php $this->load->view('rec_tpl', $value);?>
                                <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>
<div id="edit-modal-form" class="modal1 d-none br-20">
    <div class="modal-header">
        <h5 class="modal-title" id="addNewContact">Редактирование данных контакта </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body p-1">
    <div class="container ">
        <div class="row">
            <div class="col-6 p-1">
            <div class="form-group">
                <input name="editFname" type="text" class="form-control br-20 mx-auto" id="editFname" placeholder="Имя">
                </div>
                <div class="form-group">
                    <input name="editLname" type="text" class="form-control br-20 mx-auto" id="editLname" placeholder="Фамилия">
                </div>
                <div class="form-group">
                    <input name="editScope" type="text" class="form-control br-20 mx-auto" id="editScope" placeholder="Область деятельности">
                </div>
                <div class="form-group">
                    <input name="editPosition" type="text" class="form-control br-20 mx-auto" id="editPosition" placeholder="Должность">
                </div>
            </div>
            <div class="col-6 p-1">
            <div class="form-group">
                    <input name="editMphone" type="text" class="form-control br-20 mx-auto" id="editMphone" placeholder="Телефон">
                </div>
                <div class="form-group">
                    <input name="editEmail" type="text" class="form-control br-20 mx-auto" id="editEmail" placeholder="email">
                </div>
                <div class="form-group">
                    <input name="editCity" type="text" class="form-control br-20 mx-auto" id="editCity" placeholder="Город">
                </div>
                <div class="form-group">
                    <input name="editHref" type="text" class="form-control br-20 mx-auto" id="editHref" placeholder="Страница ВКонтакте">
                </div>

            </div>
        </div>
        <div id="callback_message" class="d-none"></div>
        <div class="modal-footer">
            <button id="saveDataContact" type="button" class="btn btn-outline-primary br-20 mx-auto w-50">Сохранить</button>
        </div>
    </div>
    </div>

    
</div>

<div id="add-comment-form" class="modal-comment d-none br-20">
    <div class="modal-header">
        <h5 class="modal-title" id="addComment">Добавить комментарий </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body p-1">
    <div class="container ">
        <div class="row">
            <div class="col p-1">
            <div class="form-group">
                <input name="addNewComment" type="text" class="form-control br-20 mx-auto" id="addNewComment" placeholder="Ваш комментарий">
                </div>
            </div>
        </div>
        <div id="comment_callback_message" class="d-none"></div>
        <div class="modal-footer">
            <button id="saveComment" type="button" class="btn btn-outline-primary br-20 mx-auto w-50">Сохранить</button>
        </div>
    </div>
    </div>

    
</div>

<div id="search-form" class="modal-search d-none br-20 search_box">
        <div class="modal-header">
            <h5 class="modal-title" id="searchForm">Поиск</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body p-1">
            <div class="container ">
                <div class="row">
                    <div class="col p-1">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-secondary active">
                            
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Имя
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="options" id="option2" autocomplete="off"> Должность
                        </label>
                    </div>
                        <div class="form-group">
                            <!-- <input name="search" type="text" id="search"  class="form-control br-20 mx-auto" placeholder="Введите">    -->
                            <input name="input_search" type="text" id="input_search" class="form-control br-20 mx-auto"  placeholder="Находится разработке">
                        </div>
                    </div>
                </div>
                <!-- <div id="comment_callback_message" class="d-none"></div> -->
                <div class="modal-footer">
                    <button id="startSearch" type="button" class="btn btn-outline-primary br-20 mx-auto w-50 disabled">Искать</button>
                </div>
            </div>
        </div>
        <div id="search_box-result"></div>
</div> 
<?php endif ?>



