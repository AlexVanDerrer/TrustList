<!DOCTYPE html>
<html>
<head>
	<title>Page Title</title>
    <link rel="stylesheet" href="star_rating.css">
</head>
<body>
<style>
.my-table, .my-table td {
    border: 1px solid black;
    border-collapse: collapse;
}
.my-table tr>td {
    width: 120px;
}
.my-table .table-show{
    overflow: hidden;
    position: relative;
    height: 100%;
}

.show-btn-left {
  position: absolute;
  /*left: 0;*/
  right: 0;
  bottom: 0;
  -webkit-transition: all .4s ease-in-out;
  -moz-transition: all .4s ease-in-out;
  -ms-transition: all .4s ease-in-out;
  -o-transition: all .4s ease-in-out;
  transition: all .4s ease-in-out;
  -webkit-transform: translateX(100px);
  -moz-transform: translateX(100px);
  -ms-transform: translateX(100px);
  -o-transform: translateX(100px);
  transform: translateX(100px);
}
.show-btn-right {
  position: absolute;
  left: 0;
  /*right: 0;*/
  bottom: 0;
  -webkit-transition: all .4s ease-in-out;
  -moz-transition: all .4s ease-in-out;
  -ms-transition: all .4s ease-in-out;
  -o-transition: all .4s ease-in-out;
  transition: all .4s ease-in-out;
  -webkit-transform: translateX(-100px);
  -moz-transform: translateX(-100px);
  -ms-transform: translateX(-100px);
  -o-transform: translateX(-100px);
  transform: translateX(-100px);
}

.table-show:hover .show-btn-left {
      -webkit-transform: translateX(0px);
      -moz-transform: translateX(0px);
      -ms-transform: translateX(0px);
      -o-transform: translateX(0px);
      transform: translateX(0px);
      position: absolute; 
}
.table-show:hover .show-btn-right {
      -webkit-transform: translateX(0px);
      -moz-transform: translateX(0px);
      -ms-transform: translateX(0px);
      -o-transform: translateX(0px);
      transform: translateX(0px);
      position: absolute; 
}

</style>

<table class="my-table">
    <thead>
        <tr>
            <td></td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Должность</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr><td></td>
            <td colspan=5>
                <!-- star rating data-id="page-1" -->
                <div class="star-rating__container">
                    <div class="star-rating__wrapper">
                        <div class="star-rating__avg"></div>
                        <div class="star-rating" data-id="001">
                            <div class="star-rating__bg">
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            </div>
                            <div class="star-rating__live">
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-rating="1">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-rating="2">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-rating="3">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-rating="4">
                                <path fill="currentColor"

                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            <svg class="star-rating__item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-rating="5">
                                <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                </path>
                            </svg>
                            </div>
                        </div>
                        <div class="star-rating__votes"></div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="table-show"><div class="show-btn-left"><button>Кнопка</button></div></td>
            <td>Иван</td>
            <td>Иванов </td>
            <td>директор</td>
            <td  class="table-show"><div class="show-btn-right"><a title="Удалить из списка" src="" href="#"><img src="false-50x50.png" width="15" height="15" alt="" sizes="10" srcset=""></a></div></td>
        </tr>
        <tr><td></td><td colspan=5></td></tr>
        <tr>
            <td class="table-show"><div class="show-btn-left"><button>Кнопка</button></div></td>
            <td>Иван</td>
            <td>Иванов</td>
            <td>директор</td>
            <td  class="table-show"><div class="show-btn-right"><button>Кнопка</button></div></td>
        </tr>
        <tr><td></td><td colspan=5></td></tr>
        <tr>
            <td class="table-show"><div class="show-btn-left"><button>Кнопка</button></div></td>
            <td>Иван</td>
            <td>Иванов</td>
            <td>директор</td>
            <td  class="table-show"><div class="show-btn-right"><button>Кнопка</button></div></td>
        </tr>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
<script src="star_rating.js"></script>
</body>
</html>
