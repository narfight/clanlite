<div class="big_cadre">
	<h1>{TITRE_NEWS}</h1>
  <!-- BEGIN news --> 
  <div class="news"> 
    <h2>{news.TITRE}</h2> 
    <ul class="header"> 
      <li>{POSTE_LE} <span class="reponce">{news.DATE}</span></li> 
      <li>{PAR} <span class="reponce">{news.BY}</span></li> 
      <li><a href="reaction.php?for={news.FOR}">{news.COMMENTAIRE}</a></li> 
    </ul>{news.TEXT}
    <div style="height: 30px; width: 1px"></div>
  </div> 
  <!-- END news --> 
</div>
<!-- BEGIN multi_page --> 
<div class="parpage">
<!-- BEGIN link_prev --> 
      <a href="index_pri.php?limite={multi_page.link_prev.PRECEDENT}">{multi_page.link_prev.PRECEDENT_TXT}</a> 
      <!-- END link_prev --> 
      <!-- BEGIN num_p --> 
      <a href="index_pri.php?{multi_page.num_p.URL}">{multi_page.num_p.NUM}</a>,
      <!-- END num_p --> 
      <!-- BEGIN link_next --> 
      <a href="index_pri.php?limite={multi_page.link_next.SUIVANT}">{multi_page.link_next.SUIVANT_TXT}</a> 
      <!-- END link_next -->
</div>
<!-- END multi_page --> 
