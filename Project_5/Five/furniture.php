<!DOCTYPE html>
<?php
    require_once 'logic.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Только CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Пакет JavaScript с Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styleweb.css">
</head>
<body>
    <header class="headler">
        <div class="conteiner">
            <div class="headler_block">
                <div class="headler_body">
                    <div class="headler_logo">
                        <a class="logo">
                            <img href="/" class="logo_img" src="img/logoweb.svg">
                        </a>
                        <a href="#" class="logo_text">
                            Мебель от производителя
                        </a>
                    </div>
                    <div class="headler_naw">
                        <div class="poisk">
                            <form>
                                <input type="text" placeholder="Поиск по сайту">
                                <button type="submit">
                                    <img href="/" src="img/search-icon.png">
                                </button>
                            </form>
                        </div>
                        <div class="language">
                            <a href="/" class="language_logo">
                                <img class="ru_img" src="img/ru-icon.jpg"></a>
                            <a href="/" class="language_logo">
                                <img class="pl_img" src="img/pl-icon.jpg"></a>
                            <a href="/" class="language_logo">
                                <img class="chn_img" src="img/chn-icon.jpg"></a>
                            <a href="/" class="language_logo">
                                <img class="en_img" src="img/en-icon.jpg"></a>
                            <a href="/" class="language_logo">
                                <img class="de_img" src="img/de-icon.jpg"></a>
                        </div>
                        <div class="city">
                            <div class="dropdown">
                                <button class="dropbtn"><span>Ваш город:</span><br>Волгоград</button>
                                <div class="dropdown-content">
                                    <a href="#">Москва</a>
                                    <a href="#">Ростов-на-Дону</a>
                                    <a href="#">Брянск</a>
                                    <a href="#">Орел</a>
                                    <a href="#">Курск</a>
                                    <a href="#">Нижний<br>Новнород</a>
                                    <a href="#">Все города</a>
                                </div>
                            </div>
                            <div class="city_add">
                                Адреса магазинов
                            </div>
                            <div class="city_contacts">
                                Контакты
                            </div>
                        </div>
                        <div class="registery">
                            <div class="vhod">
                                <div class="vhod_icon">
                                    <img src="">
                                </div>
                                <div class="vhod_text">
                                    Войти
                                </div>
                                <div class="vhod_title">
                                    Регестрация
                                </div>
                            </div>
                            <div class="number">
                                <div class="dropdown">
                                    <button class="dropbtn brn9">8 844-260-37-82</button>
                                    <div class="dropdown-content">
                                        <a href="#">Пн-Пт09:00-18:00</a>
                                        <a href="#">Заказать звонок</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="logo_btm">
                            <a href="#" class="btn">Заказать звонок</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="conteiner">
            <div class="body_filtraition">
                <div class="headler22">
                    Фильтрация результата поиска
                </div>
                <form action="" class="form1" method="get">
                    <div class="filtraition1">
                        <div class="filtraition2" id="fil">
                            <div class="filtraition_text2">
                                Введите ваше имя:
                            </div>
                            <div class="filtraition_input3">
                                <input name="buyer" type="text" size="50" placeholder="Ваше имяа:">
                            </div>
                        </div>
                        <div class="filtraition_text1">
                            По весу:
                        </div>
                        <div class="filtraition_input1" id="fil">
                            <input name="weight_low" type="text" size="50" placeholder="Вес от:">
                        </div>
                        <div class="filtraition_input2">
                            <input name="weight_max" type="text" size="50" placeholder="Вес до:">
                        </div>
                    </div>
                    <div class="filtraition2" id="fil">
                        <div class="filtraition_text2">
                            Фельтрация по номеру заказа:
                        </div>
                        <div class="filtraition_input3">
                            <input name="deal_number_imput" type="text" size="50" placeholder="Номер заказа:">
                        </div>
                    </div>
                    <div class="filtraition3" id="fil">
                        <div class="filtraition_text2">
                            Фельтрация по описанию:
                        </div>
                        <div class="filtraition_input4">
                            <!-- <input name="composition_imput" type="text" size="50" placeholder="Введите описание мебели:"> -->
                            <div>
                                <select name="composition_imput" type="text">
                                    <?php foreach($selection as $item):?>
                                        <option value="<?=$item['composition']?>"><?=$item['composition']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="filtraition_button" id="fil">
                        <div class="filtraition_button1">
                            <button class="fil_b1" type="submit">Применить фильтр</button>
                        </div>
                        <div class="filtraition_button2">
                            <button name="clearFilter" class="fil_b2" type="submit">Очистить фильтр</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="opisanie_obs">
        <div class="conteiner">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Изображение</th>
                            <th scope="col">Номер заказа</th>
                            <th scope="col">Описание заказа</th>
                            <th scope="col">Вес заказа</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $item):?>
                            <tr>
                                <th dcope="row"">
                                    <img src="inc_img/<?=$item['check_photo']?>.jpg" style="max-width: 150px; max-height: 150px;">
                                </th>
                                <td><?=$item['deal_number']?></td>
                                <td><?=$item['composition']?></td>
                                <td><?=$item['weight']?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        </div>
    </section>
</body>