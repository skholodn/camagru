<?php if(Session::isLoggedOnUser()): ?>
	<h1 class='text-center'>All photos gallery</h1>
<?php else: ?>
	<h1 class='text-center'>Log in the site to create your own photos and like others.</h1>
<?php endif; ?>
<?php if(Session::isLoggedOnUser()): ?>
	<div class="container">
		<div align="center">
			<button class="btn btn-primary filter-button" data-filter="add-photo" onclick="location.href='/photo';">Add new photo</button>
		</div>
	</div>
<?php endif; ?>

 <div class="container-fluid">
	<div class="row">
		
		<div class="col-sm-3 container" style="background-color: #F5F5F5;">
			<?php if($users): ?>
				<?php foreach ($users as $user) : ?>
					<button id="<?= $user['login']?>" class="btn btn-primary btn-block <?php if ($user['same']) echo 'disabled'; ?>" onclick="setUserFilter('<?= $user['login']?>'); return false;">
						<?php if ($user['login'] == Session::get('user_name'))
								echo '<i class="fas fa-star" style="color:yellow;"></i>'?>
						<?php echo $user['login']?>
					</button>
				<?php endforeach; ?>
			<?php else: ?>
				<h3>No users to be shown!</h3>
			<?php endif; ?>		
		</div>


		<div class="col-sm-9 container">
			<div class="row">

				<?php if($images && is_array($images)): ?>

				<?php foreach ($images as $image): ?>

					<div class="col-md-4">
						<div class="thumbnail">
							<a href="<?php $id = $image['id']; echo '/gallery/image/'.$id; ?>" target="_blank">
								<img src="<?= $image['path'] ?>" alt="" style="width:100%">
							</a>
							<?php if (Session::get('user_name') == $image['login'])
							{
								echo '<img class="redCross" src="/img/site/redCross.png" alt="" onclick="
									deleteImg('.$image['id'].',\''.$image['path'].'\'); return false;">';
							}
							?>
							<div class="caption text-info d-flex justify-content-between">
								<div>
									<?= $image['login']?>
								</div> 
								<div>
									<i class="far fa-envelope"></i>
									:<?= $image['comments']?>
									<i id="<?= $image['id']?>" class="<?= ($image['liked']) ? 'fas' : 'far'?> fa-thumbs-up" onclick="
									makeLike(<?= $image['id']?>, '<?= $image['login']; ?>'); return false;"></i>
									:<span id="<?= $image['id']?>_numb"><?= $image['likes']?></span>
								</div>
							</div>	
						</div>
					</div>
				<?php endforeach; ?>

				<?php else: ?>
					<div class="col-md-4">
						<p class="justify-content-center">No photos to be shown!</p>
					</div>
				<?php endif; ?>
			</div>

		<div class="container"></div>
		<div class="row align-content-center justify-content-center">
			<ul class="pagination">
				<li class="page-item <?php if($page == 1) echo 'disabled'; ?>"><a class="page-link" href="/gallery/<?= $page - 1;?>">Previous</a></li>
  				<?php for ($i = 1; $i <= $max_page; $i++): ?>
  				<li class="page-item <?php if($page == $i) echo 'active'; ?>"><a class="page-link" href="/gallery/<?= $i ?>"><?= $i ?></a></li>
  				<?php endfor; ?>
  				<li class="page-item <?php if($page == $max_page) echo 'disabled'; ?>"><a class="page-link" href="/gallery/<?= $page + 1;?>">Next</a></li>
			</ul>
		</div>
	</div>

			</div>
		</div>
	</div>
</div>
<script src="/js/gallery.js"></script>