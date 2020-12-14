<!-- Pls give credits -->


<html>

<head>


    <link href="wbindex.css" rel="stylesheet" id="bootstrap-css">
        <link rel="icon" href="<?php echo $site_icon; ?>" type="image/png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"> <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"> <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"> <link rel="manifest" href="/site.webmanifest">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<title>●●</title>
</head>

<!--<body style="background-color: #2a2a2a">
<style>
body {
  background-image: url('bg.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed; 
  background-size: 100% 100%;
} -->
</style>
    <center><h6 class="h6"><img onmouseover="this.src='luffy.png'" onmouseout="this.src='luffy.png'" src="luffy.png"  title="Edited By Luffy" style="width:400px;"/></h6>
    </center>
<class="">
<class="md-form">
<center><div class="md-form">
<span><textarea  type="text" style="background: transparent;color: #FFFFFF;overflow:hidden; text-align: center; width: 50%" id="lista" class="md-textarea form-control" rows="4" placeholder="Enter Cards"></textarea></span>

<center>

<span>Cards:</span>&nbsp<span id="total" class="badge badge-warning">0</span>&nbsp/&nbsp<span id="carregadas" class="badge badge-danger">0</span>
</div>
</center>
<br>
<br>
<center>
 <button class="btn btn-outline-primary" style="width: 17%; outline: none;" id="testar" onclick="enviar()" >START</button>


</center></center></center>
<br>
<br>
<center>
<div class="col-md-">
<div class="card">
<center>    <button id="mostra" style="width: 30%;" class="btn btn-outline-success">Approved&nbsp<span id="cLive" class="badge badge-success">0</span></button><br>
    <div id="bode"><span id=".aprovadas" class="aprovadas"></span></br></center>

<br>
<div class="card">
<center>    <button id="mostra2" style="width: 30%;" class="btn btn-outline-warning" >CCN&nbsp <span id="cWarn" class="badge badge-warning"> 0</span> </button>

   
    <div id="bode2"><span id=".edrovadas" class="edrovadas"></span></center>
</div>
</div>

<br>

<div class="card">
<center>    <button id="mostra3" style="width: 30%;" class="btn btn-outline-danger">Declined&nbsp <span id="cDie" class="badge badge-danger"> 0</span> </button>

   
    <div id="bode3"><span id=".reprovadas" class="reprovadas"></span></center>
    </div>

<br>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){

 $("#bode").hide();
  $("#esconde").show();
  
  $('#mostra').click(function(){
  $("#bode").slideToggle();
  });
  
  $('#mostra3').click(function(){
  $("#bode3").slideToggle();
  });
  
   $('#mostra2').click(function(){
  $("#bode2").slideToggle();
  });

});

</script>

<script title="ajax do checker">
    function enviar() {
        var linha = $("#lista").val();
        var linhaenviar = linha.split("\n");
        var total = linhaenviar.length;
        var ap = 0;
        var ed = 0;
        var rp = 0;
        linhaenviar.forEach(function(value, index) {
            setTimeout(
                function() {
          var sec = $("#sec").val();
                    $.ajax({
                        url: 'api.php?lista=' + value + '&sec=' + sec,
                        type: 'GET',
                        async: true,
                        success: function(resultado) {
                            if (resultado.match("CVV")) {
                                removelinha();
                                ap++;
                                aprovadas(resultado + "");
                              }else if(resultado.match("CCN")){
                              removelinha();
                            ed++;
                                edrovadas(resultado + "");
                            }else {
                                removelinha();
                                rp++;
                                reprovadas(resultado + "");
                            }
                            $('#carregadas').html(total);
                            var fila = parseInt(ap) + parseInt(ed) + parseInt(rp);
                           $('#cLive').html(ap);
                            $('#cWarn').html(ed);
                            $('#cDie').html(rp);
                            $('#total').html(fila);
                            $('#cLive2').html(ap);
                            $('#cWarn2').html(ed);
                            $('#cDie2').html(rp);
                        }
                    });
                }, 1000 * index);
        });
    }
    function aprovadas(str) {
        $(".aprovadas").append(str + "<br>");
    }
    function reprovadas(str) {
        $(".reprovadas").append(str + "<br>");
    }
     function edrovadas(str) {
        $(".edrovadas").append(str + "<br>");
    }
    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }
</script>

<footer>
<!-- <center><p><a href="https://45019a8eeef8.ngrok.io">take me home</a></p></center> -->
</footer>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
<script src="./removeBanner.js"></script>

</body>
<footer>
    <center><h6 class="card- h6"><img onmouseover="this.src='luffy1.png'" onmouseout="this.src='luffy1.png'" src="luffy1.png"  title="Edited By Luffy" style="width:200px;"/></h6>
    <center><p>©𝖟𝖞𝖓𝖈𝖇𝖔𝖎𝖎<p></center>
</footer>
</html>
