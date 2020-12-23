<div class="cms-subsites" data-pjax-fragment="SubsiteList">
	<div class="field dropdown">
		<select id="HmkSubsitesSelect">
			<% loop $HmkListSubsites %>
				<option value="$Link" $CurrentState>$Title</option>
			<% end_loop %>
		</select>
	</div>
</div>
