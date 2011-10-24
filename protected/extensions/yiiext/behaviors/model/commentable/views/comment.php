<p>
	<strong><?//=CHtml::link(CHtml::encode($comment->author->username), array('user/profile', 'id'=>$comment->author->id))?></strong>

	<?=Yii::app()->dateFormatter->format('dd.MM.yyyy, HH:mm', $comment->datetime)?>				
	<?=CHtml::link('#'.$comment->getPrimaryKey(), '#comment-'.$comment->getPrimaryKey())?>
</p>
<?=$comment->content ?>
