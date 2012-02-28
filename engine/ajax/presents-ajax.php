<div id="closePresent"></div>
<div id="presentsLogo">Подарки</div>
<div id="presentsContent">
<?php
/*
* Подарки
*/
require_once '../../config/config.php';
$db = start_db();
    /* за 2 золотых --------------------------------------------- */
    ?>
    <div class="presentTitle">
        <div class="presentCat">Подарки за 2</div>
        <div class="presentLine"></div>
    </div>
    <div class="presentErrow_left"></div>   
    <ul class="presentsPictures">  
    <?php
    $query = mysql_query('SELECT * FROM '.DB_PREFIX.'Presents WHERE present_price="2"', $db);
    while ($presents = mysql_fetch_object($query)) :
        ?>
            <li id="present_<?php echo $presents -> ID_present?>"><img src="images/<?php echo $presents -> logo?>"/></li>
        <?php
    endwhile;
    ?>
    </ul>
    <div class="presentErrow_right"></div>     
    <?php
close_db($db);
?> 
    <div class="presentTitle">
        <div class="presentCat">Подарки за 6</div>
        <div class="presentLine"></div>
    </div>
    <div class="presentErrow_left"></div> 
    <ul class="presentsPictures">
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>

    </ul>     
    <div class="presentErrow_right"></div>   
    <div class="presentTitle">
        <div class="presentCat">Подарки за 12</div>
        <div class="presentLine"></div>
    </div>
    <div class="presentErrow_left"></div> 
    <ul class="presentsPictures">
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
    </ul>  
    <div class="presentErrow_right"></div>
    <div class="presentTitle">
        <div class="presentCat">Подарки за 18</div>
        <div class="presentLine"></div>
    </div>
    <div class="presentErrow_left"></div> 
    <ul class="presentsPictures">
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>
        <li><img src="images/presents/1.jpg"/></li>        
    </ul> 
    <div class="presentErrow_right"></div> 
    <div class="presentTitle">
        <div class="presentCat">Подарки за 1</div>
        <div id="presentVip"> - Доступны только для пользователей со статусом VIP</div>
    </div> 
    
                             
</div>