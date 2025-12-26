<section>
	<div class="container-fluid">
	  <div class="row justify-content-center">
		<div class="col-md-6">
		    <div class="block heading empty-heading text-center">
				<div class="card">
					<div class="card-body">
						<h3 class="pb-3"><?=_lang('empty_cart_heading_text','cart')?></h3>
						<form action="<?=SITE_URL?>search" method="post">
							<div class="form-group">
							<input type="text" name="search" class="form-control neame_search border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">
							</div>
						</form>
						<div class="h4 text-center text-muted pt-2 pb-2"><?=_lang('empty_cart_or_word_text','cart')?></div>
            			<a href="<?=$sell_page_link?>" class="btn btn-primary choose_brand btn-lg pl-3 pr-3"><?=_lang('empty_cart_choose_device_button_text','cart')?></a>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</section>
