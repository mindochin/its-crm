<?php
$this->breadcrumbs = array('Панель управления');?>
<h2>Приветствую, о <?php echo (isset(Yii::app()->getModule('user')->user()->profile->displayname) ? (Yii::app()->getModule('user')->user()->profile->displayname) : (Yii::app()->user->name));?>!</h2>
<p>Здесь осуществляется Администрирование сайта.</p>
<p>Обратите внимание - при длительном бездействии пароль обнуляется и запрашивается страница входа, все несохраненные изменения могут потеряться. </p>
<h3>Краткая сводка</h3>
<?php
//foreach ($info as $row)
{
	echo '<ul>';
	echo '<li>Статей: <span class="strong">'.$info['story_count'].'</span></lip>';
	echo '<li>Страниц: <span class="strong">'.$info['page_count'].'</span></li>';
//	echo '<li>Комментариев: <span class="strong">'.$info['comment_count'].'</span></li>';
//	echo '<p>Сообщений в гостевой:','<span class="strong">'.$row['gb_count'].'</span></p>';
//	echo '<p>Фотогалерей:','<span class="strong">'.$row->num_gallery.'</span></p>';
//	echo 'Фотографий в галереях:','<span class="strong">'.$row->num_photo.'</span></p>';
	echo '</ul>';
}
Yii::import('ext.Echeckpr');
$checkpr = new Echeckpr();
echo '<h3>Дополнительно</h3>';
echo '<ul><li>'.CHtml::link('Перейти на Панель Управления хостинга','https://cp.hc.ru/services/vh/vladname.ru/index.html').'</li>';
echo '<li>'.  CHtml::link('Перейти к БД хостинга','https://phpmyadmin.hc.ru/').'</li>';
echo '<li>'.  CHtml::link('Перейти к Google Analytics','http://www.google.com/analytics/ru-RU/').'</li></ul>';
echo '<h3>Положение/вес сайта в Интернете</h3>';
echo '<ul><li>Значение Яндекс.тИЦ, полученное из Яндекс.Бара: <span class="strong">'.$checkpr->getBarCY('vladname.ru').'</span></li>';
echo '<li>Значение Яндекс.тИЦ, полученное из Яндекс.Каталога: <span class="strong">'.$checkpr->yandex_tic('vladname.ru').'</span></li>';
echo '<li>Значение Google PageRank: <span class="strong">'.$checkpr->getpr('vladname.ru').'</span></li></ul>';
//$this->table->add_row('Яндекс цитирования','<a href="http://yandex.ru/cy?base=0&amp;host=vladname.ru"><img src="http://www.yandex.ru/cycounter?vladname.ru" width="88" height="31" alt="Яндекс цитирования" border="0" /></a>');

?>
