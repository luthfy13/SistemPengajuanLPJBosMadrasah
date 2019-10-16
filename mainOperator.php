<?php
	include "headerOperator.php";
?>

<div id="main">
	<div id="divForm">
		<form method="POST" action="pengajuanLPJ.php">
			<div class="custom-select" style="width:300px;">
				<select id="optTahun" name="optTahun">
					<optgroup>
						<option value="0">Tahun Ajaran:</option>
						<option value="2017/2018">2017/2018</option>
						<option value="2018/2019">2018/2019</option>
						<option value="2019/2020">2019/2020</option>
					</optgroup>
				</select>
			</div>
			<br>
			<div class="custom-select" style="width:300px;">
				<select id="optTahap" name="optTahap">
					<option value="0">Tahap:</option>
					<option value="Tahap I">Tahap I</option>
					<option value="Tahap II">Tahap II</option>
				</select>
			</div>
			<br>
			<input type="submit" value="Lanjut" id="btnLanjut">
			
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){

// 		$("head").append("<link>");
// 		var css = $("head").children(":last");
// 		css.attr({
// 			rel:  "stylesheet",
// 			type: "text/css",
// 			href: "scripts/combobox-style.css"
// 		});
		function setComboboxStyle(){
			var x, i, j, selElmnt, a, b, c;
			x = document.getElementsByClassName("custom-select");
			for (i = 0; i < x.length; i++) {
			  selElmnt = x[i].getElementsByTagName("select")[0];
			  a = document.createElement("DIV");
			  a.setAttribute("class", "select-selected");
			  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
			  x[i].appendChild(a);
			  b = document.createElement("DIV");
			  b.setAttribute("class", "select-items select-hide");
			  for (j = 0; j < selElmnt.length; j++) {
			    c = document.createElement("DIV");
			    c.innerHTML = selElmnt.options[j].innerHTML;
			    c.addEventListener("click", function(e) {
			        var y, i, k, s, h;
			        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
			        h = this.parentNode.previousSibling;
			        for (i = 0; i < s.length; i++) {
			          if (s.options[i].innerHTML == this.innerHTML) {
			            s.selectedIndex = i;
			            h.innerHTML = this.innerHTML;
			            y = this.parentNode.getElementsByClassName("same-as-selected");
			            for (k = 0; k < y.length; k++) {
			              y[k].removeAttribute("class");
			            }
			            this.setAttribute("class", "same-as-selected");
			            break;
			          }
			        }
			        h.click();
			        //edited by luthfy13 for "change" event
			        var event;
			        try {
			          event = new Event("change")
			        } catch (e) {
			          event =  document.createEvent("Event");
			          event.initEvent("change", true, false);
			        }
			        s.dispatchEvent(event);
			        //----------------
			    });
			    b.appendChild(c);
			  }
			  x[i].appendChild(b);
			  a.addEventListener("click", function(e) {
			      e.stopPropagation();
			      closeAllSelect(this);
			      this.nextSibling.classList.toggle("select-hide");
			      this.classList.toggle("select-arrow-active");
			    });
			}
		}

		
		function closeAllSelect(elmnt) {
		  var x, y, i, arrNo = [];
		  x = document.getElementsByClassName("select-items");
		  y = document.getElementsByClassName("select-selected");
		  for (i = 0; i < y.length; i++) {
		    if (elmnt == y[i]) {
		      arrNo.push(i)
		    } else {
		      y[i].classList.remove("select-arrow-active");
		    }
		  }
		  for (i = 0; i < x.length; i++) {
		    if (arrNo.indexOf(i)) {
		      x[i].classList.add("select-hide");
		    }
		  }
		}
		document.addEventListener("click", closeAllSelect);
		
		$("#mn1").css({
			"background-color" : "gray",
			"color" : "white"
		});

		$("#btnLanjut").click(function(e){
			if ($("#optTahun").val() == "0" || $("#optTahap").val() == "0"){
				e.preventDefault();
				swal({
					type: 'error',
					text: 'Tahun ajaran dan tahap belum dipilih!!!',
				});
			}
		});

		setComboboxStyle();
	});
</script>

<?php 
	include "footer.php";
?>