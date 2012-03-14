{extends file="base.tpl"}

{block name="body"}
	<h2>{message name="page-gallery-title"}</h2>
	<div id="thumbnails">
		<div class="thumbcontainer">
			<div class="therounit">
				<div class="thumb thero">
					<img src="{$galimg1}" />
				</div>
			</div>
			<div class="theroside">
				<div class="thumb">
					<img src="{$galimg1}" />
				</div>
				<div class="thumb">
					<img src="{$galimg1}" />
				</div>
			</div>
		</div>
		<div class="thumbcontainer">
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
		</div>		
		<div class="thumbcontainer">
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
		</div>		
		<div class="thumbcontainer">
			<div class="therounit">
				<div class="thumb thero">
					<img src="{$galimg1}" />
				</div>
			</div>
			<div class="theroside">
				<div class="thumb">
					<img src="{$galimg1}" />
				</div>
				<div class="thumb">
					<img src="{$galimg1}" />
				</div>
			</div>
		</div>
		<div class="thumbcontainer">
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
			<div class="thumb">
				<img src="{$galimg1}" />
			</div>
		</div>		
	</div>
{/block}

{* The idea for this is:
  +-----------+ +----+
  |           | |    |
  |           | +----+
  |           | +----+
  |           | |    |
  +-----------+ +----+
  +----+ +----+ +----+
  |    | |    | |    |
  +----+ +----+ +----+
*}
