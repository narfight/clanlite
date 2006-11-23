<!-- BEGIN match -->
	{TXT_DATE} :<span class="reponce">{DATE}</span><br />
	{TXT_HEURE} :<span class="reponce">{HEURE}</span><br />
	<span class="reponce">{SECTION}</span> VS <span class="reponce">{CONTRE}</span><br />
	<span class="reponce">{INFO}</span>
<!-- END match -->
<!-- BEGIN entrain -->
	{TXT_DATE} :<span class="reponce">{DATE}</span><br />
	{TXT_HEURE} :<span class="reponce">{HEURE}</span><br />
	{TXT_INFO}:<br />
	<span class="reponce">{INFO}</span>
<!-- END entrain -->
<!-- BEGIN last_match -->
	{TXT_DATE}: <span class="reponce">{DATE}</span><br />
	{TXT_CONTRE}: <span class="reponce">{CONTRE}</span><br />
	{TXT_PT_NOUS}: <span class="reponce">{PT_NOUS}</span><br />
	{TXT_PT_MECHANT}: <span class="reponce">{PT_MECHANT}</span><br />
	<a href="javascript:toggle_msg('last_match_resum', '', '')">{INFO_SHOW_INFO}</a>
	<div style="display: none;" id="last_match_resum">{INFO}</div>
<!-- END last_match -->