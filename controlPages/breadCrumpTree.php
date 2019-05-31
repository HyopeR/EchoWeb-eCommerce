<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$_SERVER[QUERY_STRING]";
$pagenameExp = explode("/", $url);
$pageExp = explode(".", $pagenameExp[count($pagenameExp)-1]);
$pageName = $pageExp[0];

echo '
<div id="breadcrumb" class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="breadcrumb-tree">
';
            for ($i = 0; $i < count($pagenameExp); $i++) {

              $space = $i + 2;
              if($space == count($pagenameExp)-1) {
                echo '<li class="active">'.$pageName.'</li>';
                break;
              }
              else if($space == 2) {
                echo '<li><a href="'.SCRIPT_ROOT.'">Ana Sayfa</a></li>';
              }

              else if($space == 3) {
                echo '<li><a href="'.SCRIPT_ROOT.$pagenameExp[3].'">'.$pagenameExp[3].'</a></li>';
              }

              else if($space == 4) {
                echo '<li><a href="'.SCRIPT_ROOT.$pagenameExp[3]."/".$pagenameExp[4].'">'.$pagenameExp[4].'</a></li>';
              }

              else if($space == 5) {
                echo '<li><a href="'.SCRIPT_ROOT.$pagenameExp[3]."/".$pagenameExp[4]."/".$pagenameExp[5].'">'.$pagenameExp[5].'</a></li>';
              }

              else if($space == 6) {
                echo '<li><a href="'.SCRIPT_ROOT.$pagenameExp[3]."/".$pagenameExp[4]."/".$pagenameExp[5]."/".$pagenameExp[6].'">'.$pagenameExp[6].'</a></li>';
              }
            }
echo '
        </ul>
      </div>
    </div>
  </div>
</div>
';
?>
