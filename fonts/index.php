<!DOCTYPE html>
<html>
<head>
<style> 
*{
	font-family: Tahoma;
	font-size: 50px;
}
div {
    width: 500px;
    height: 50px;
    font-weight: bold;
    position: relative;
    -webkit-animation: mymove 5s infinite; /* Safari 4.0 - 8.0 */
    animation: mymove 5s infinite;
}

/* Safari 4.0 - 8.0 */
#div1 {-webkit-animation-timing-function: linear;}
#div2 {-webkit-animation-timing-function: ease;}
#div3 {-webkit-animation-timing-function: ease-in;}
#div4 {-webkit-animation-timing-function: ease-out;}
#div5 {-webkit-animation-timing-function: ease-in-out;}

/* Standard syntax */
#div1 {animation-timing-function: linear;}
#div2 {animation-timing-function: ease;}
#div3 {animation-timing-function: ease-in;}
#div4 {animation-timing-function: ease-out;}
#div5 {animation-timing-function: ease-in-out;}

/* Safari 4.0 - 8.0 */
@-webkit-keyframes mymove {
    from {left: 0px;}
    to {left: 600px;}
}

/* Standard syntax */
@keyframes mymove {
    from {left: 0px;}
    to {left: 600px;}
}
</style>
</head>
<body>

<p><strong>Web Developer:</strong> Lutfi Budi Ilmawan</p>

<div id="div1">Aga</div>
<div id="div2">muala</div>
<div id="div3">lettu</div>
<div id="div4">akkue</div>
<div id="div5">la marupe'?</div>

</body>
</html>
