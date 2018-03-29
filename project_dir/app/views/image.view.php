<div class="container-fluid">
	<div class="row">
		
		<div class="col-sm-9" style="background-color: black;">
			<img class="center-block" src="/<?= $image['path'] ?>" alt="<?= $image['id'] ?>" style="width:100%">
		</div>


		<div class="col-sm-3 detailBox" style="background-color: #F5F5F5;">

			<div id="<?= $image['id'] ?>" class="commentBox">
				<div class="imageInfoBox">
					<div class="commenterImage">
						<img src="/<?= $image['owner_avatar'] ? $image['owner_avatar'] : 'img/site/profile.jpg'; ?>" />
					</div>
					<h3><?= $image['login']; ?></h3>
					
					<div class="pull-right likesComments">
						<i  class="far fa-envelope"></i>
						: <span id="<?= $image['id'] ?>_commentsNumb"><?= $image['comments']; ?> </span>
						<i id="<?= $image['id'] ?>_like" class="<?= ($image['liked']) ? 'fas' : 'far'?> fa-thumbs-up" onclick="
							makeLike(<?= $image['id'] ?>, '<?= $image['login'] ?>'); return false;"></i>
						: <span id="<?= $image['id'] ?>_likeNumb"><?= $image['likes']?> </span>
					</div>

					<span class="date sub-text"><?= $image['date']?></span>
				</div>

				<div class="actionBox">
				<?php if (Session::isLoggedOnUser()): ?>
					<div class="form-group">
						<form method="POST" name="add_comment" id="add_comment" class="form-inline" role="form" onsubmit="addComment(<?= $image['id'] ?>, '<?= $image['login'] ?>');return false;">
							<div class="form-group">
								<input id="text_comment" name="text_comment" class="form-control" type="text" placeholder="Comment it!!!" />
							</div>
							<div class="form-group">
								<button class="btn btn-primary">Add</button>
							</div>
						</form>
					</div>
				<?php endif; ?>
					<ul id="infiniteComments" class="commentList">

					</ul>
				</div>

			</div>
		</div>
	</div>
</div>
<script src="/js/image.js"></script>