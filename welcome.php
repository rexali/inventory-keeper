<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>

 <!DOCTYPE html>
 <html>
 <head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bushara Business Transaction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery-3.3.1.min.js"></script>
  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    
    <script src="main.js"></script>

    
<style>

body{font-size:12px;}
.col1, .col3, .col4, .col5, .col6, .col7, .col8, .col9, .col10, .col11{
width: 6%;
float: left;
}
.col2{
    width: 20%;
    float: left;
}
.col12 {
width: 20%;
float:left;
}
.row2{
    display:none;
}
#send{

display:none ;
}
input{
    width:50px;
}

</style>

<script type="text/javascript">

$(document).ready(function(){

    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();

        var resultDropdown = $(this).siblings(".result");

        if(inputVal.length){

            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });

        } else{
             
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});

</script>
</head>

<body>
<div class="page-header">
        <h1 align='center'>Hi, Admin<b><?php //echo $_SESSION['username']; ?></b>. Welcome to our Transaction Web App.</h1>
    </div>



<p id="rst"></p>


<p id="prn" align='center'></p>

<div class="search-box pull-center" align='center'>

    <input type="text" autocomplete="off" style="width:50%; margin-top: 30px;" placeholder="Search available drugs and prices..." />

    <div class="result"></div>

</div>

<p style="margin-top:30px;"> <button type="button" id='adr' style="float:right; margin-right:50px;" onclick="adr()"> Add New Drug</button>

<button type="button" style="float:left; margin-left:50px;" onclick="read()">Refresh</button></p>

<p id="dis" style="margin-top:75px;" align='center'></p>

<div id='rdt' align='center' style="margin-top:120px; text-decoration:underlined;"></div>

<div style="margin-top:300px; text-align:center;"><button onclick="previous()">Prev</button>&nbsp;&nbsp;<button onclick="next()">Next</button></div>

<div id="send" style="margin-top:50px;"><form name = "belliform" align="center"><label for="">Items Description:</label>        <input type="text" name="items_description" style="width: 40%;" ><br><br> <label for=""> Quantity Supplied :</label>        <input type="text" name="quantity_supplied"  style="width: 5%;"> <label for="">Quantity Available:</label>     <input type="text" name="quantity_available" style="width: 5%;"> <label for="">Quantity Sold:</label>     <input type="text" name="quantity_sold" style="width: 5%;">  <label for="">Unit Selling Price:</label>        <input type="text" name="unit_selling_price" style="width: 5%;" > <label for=""> Unit Cost Price :</label>        <input type="text" name="unit_cost_price" style="width: 5%;">  <label for="">Unit Profit:</label>     <input type="text" name="unit_item_profit" style="width: 5%;"> <br><br> <input type="button" onclick="newrecord()" value="ADD"></form></div> 




<script>
    
    // To display the data
    readt();
    read(0,10);

   function printTime() {
       
      var d=new Date();
    
      //var h = d.getHours();
      //var m = d.getMinutes();
      //var s = d.getSeconds();
    
     return document.getElementById('demo').innerHTML= d; // h+':'+m+':'+s;
      //return h+':'+m+':'+s;
   }
   // to call the time every second
   setInterval(printTime,1000);


    function adr(){

        var snd =document.getElementById("send").style.display='block';

        //document.getElementById("adr").onclick = function() {

        if(snd=="none"){

        document.getElementById("send").style.display="none";

        }

        
        

    }

function save() {

        alert("Do you really want to edit this record?\n\nHit the SAVE button again to update.");

        var sav = document.getElementsByClassName("ed");

        for ( i = 0; i < sav.length; i++) {

            sav[i].onclick=function(){

                //alert("how are you");
                
                var fg =this.parentNode.parentNode;
                var iti= fg.item_id.value;
                var itd= fg.items_description.value;
                var qtsu = fg.quantity_supplied.value;
                var qta = fg.quantity_available.value;
                var qtso = fg.quantity_sold.value;
                var uspr = fg.unit_selling_price.value;
                var ucpr = fg.unit_cost_price.value;
                var uipr = fg.unit_item_profit.value;
                var tspr = fg.total_selling_price.value;
                var tcpr = fg.total_cost_price.value;
                var tpr = fg.total_profit.value;


                fg.svfm.value='Saving...'; 
                
                //document.getElementById("rst").innerHTML=iti+','+itd+','+qtsu+','+qta+','+qtso+','+uspr+','+ucpr+','+uipr+','+tspr+','+tcpr+','+tpr;
                subm(iti,itd,qtsu,qta,qtso,uspr,ucpr,uipr,tpr,tcpr,tspr);
            
                fg.svfm.value='Saved';

               setTimeout(read,1000);
               readt();

        
            }
            
        }
    }
    
    function sold() {

        var i;

        var sold = document.getElementsByClassName("sold");

        for (i= 0; i< sold.length; i++) {
            
            sold[i].onclick  = function() {

                var fg =this.parentNode.parentNode;

                var id = fg.childNodes[0].innerHTML;

                var nd = fg.childNodes[1].innerHTML;

                var sup = fg.childNodes[2].innerHTML;

                var ava = fg.childNodes[3].innerHTML;

                var qsld = fg.childNodes[4].innerHTML;

                var sp = fg.childNodes[5].innerHTML;

                var cp = fg.childNodes[6].innerHTML;

                var p = fg.childNodes[7].innerHTML;

                var ts = fg.childNodes[8].innerHTML;

                var tc = fg.childNodes[9].innerHTML;

                var tpr = fg.childNodes[10].innerHTML;

               // alert("Have you sold an item that you want to update the old stock?  \n\n Click the \'+QtySold\' button again to update");

               // var qsov = th.quantity_sold.value;

               //document.getElementById("rst").innerHTML=id+','+nd+','+sup+','+ava+','+qsld+','+ts+','+tpr ;

               var sld = prompt("Enter the quantity you have sold.");

                var rsld = new Number(qsld) + new Number (sld);

                var rava =new Number(sup) - new Number(qsld) - new Number (sld);


                var rts =new Number(rsld) * new Number(sp)+ new Number(ts);

                var rtc =new Number(rsld) * new Number(cp)+ new Number(tc);

                var rtp =new Number(rsld) * new Number(p) + new Number(tpr);



                //document.getElementById("rst").innerHTML=rsld;
                
               subm(id,nd,sup,rava,rsld,sp,cp,p,rtp,rtc,rts);

               setTimeout(read,1000);
               readt();
 
            }
            
        }
    }

    function supplied() {

        var supplied = document.getElementsByClassName("supl");

        for (let i= 0; i< supplied.length; i++) {
            
            supplied[i].onclick= function() {

              var fg = this.parentNode.parentNode;

              var id = fg.childNodes[0].innerHTML;

              var nd = fg.childNodes[1].innerHTML;

              var sup = fg.childNodes[2].innerHTML;

              var ava = fg.childNodes[3].innerHTML;

              var qsld = fg.childNodes[4].innerHTML;

              var sp = fg.childNodes[5].innerHTML;

              var cp = fg.childNodes[6].innerHTML;

              var p = fg.childNodes[7].innerHTML;

              var ts = fg.childNodes[8].innerHTML;

              var tc = fg.childNodes[9].innerHTML;

              var tpr = fg.childNodes[10].innerHTML;

               // alert("Have you sold an item that you want to update the old stock?  \n\n Click the \'+QtySold\' button again to update");

               // var qsov = th.quantity_sold.value;

            //document.getElementById("rst").innerHTML=id+','+nd+','+sup+','+ava+','+qsld+','+ts+','+tpr ;

            var supl = prompt("Enter the quantity supplied.");

            var rsup= new Number(sup) + new Number(supl);

            var rava = new Number(ava) + new Number (supl);

            subm(id,nd,rsup,rava,qsld,sp,cp,p,tpr,tc,ts);


                //updater();

            setTimeout(read,1000);
            readt();


                
              // alert("Do have an item that you want to update the old stocks? \n\nClick the \'+QtySuppl\' button again to update"); 
            }
            
        } 
    }
    

     function edit() {
         
       
    var row1 =document.getElementsByClassName("row1");
    
    for (i = 0; i < row1.length; i++) {
        
    
    row1[i].addEventListener("click",function() {
    
       var row2 = this.nextElementSibling;
    
       if (row2.style.display==="block") {

           row2.style.display="none";

        } else {

            row2.style.display="block";
        }
    
    });
    
    }
} 

//adding data to database

function newrecord() {


   var itd,qtsu,qta,qtso,usp,ucp,uip,x='';

   itd= document.forms["belliform"]["items_description"].value;

   qtsu = document.forms["belliform"]["quantity_supplied"].value;

   qta= document.forms["belliform"]["quantity_available"].value;

   qtso = document.forms["belliform"]["quantity_sold"].value;
   //
   usp = document.forms["belliform"]["unit_selling_price"].value;

   ucp = document.forms["belliform"]["unit_cost_price"].value;

   uip = document.forms["belliform"]["unit_item_profit"].value;

   //lnm = document.forms["belliform"]["lastname"].value;

   var obj = { "items_description":itd,"quantity_supplied":qtsu,"quantity_available":qta,"quantity_sold":qtso,"unit_selling_price":usp,"unit_cost_price":ucp,"unit_item_profit":uip };

  // document.getElementById("prn").innerHTML="sending data...";
  //alert("You are adding new record.");
  var dia = confirm("Do you want to add new record?");

  if ( dia == true){

  document.getElementById("prn").innerHTML="sending data...";

  var dbParam = JSON.stringify(obj);

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){

    if (this.readyState == 4 && this.status == 200) {

        var myObj = JSON.parse(this.responseText);

        document.getElementById("prn").innerHTML=myObj.success;

        document.getElementById("send").style.display='none';

        read();
        readt();
        
    }


};

xmlhttp.open("POST", "crt.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("x=" + dbParam);
}

}


//retrieving data from database

function read(lmt=0,pl=10) {

var obj, dbParam, xmlhttp, myObj, x, lmt,pl, txt = "";

obj = { "table":"bushara", "limit":lmt+ ',' +pl };

document.getElementById("dis").innerHTML="Reading data .... Please wait";

dbParam = JSON.stringify(obj);

  if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
    } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange = function() {
    
    if (this.readyState == 4 && this.status == 200) {
       
        myObj = JSON.parse(this.responseText);

       // txt += "<select style = 'margin-top:20px;'>";

       // for (x in myObj) {

       // txt += "<option>" + myObj[x].items_description+ "</option>";

       //  }

       //  txt += "</select><br><br><p id='prn' align='center' style='color:green;'></p>";

        txt +="<div class='row'><div class='col1'>No.</div><div class='col2'>Items Description</div> <div class='col3'>Quantity Supplied</div><div class='col4'>Quantity Available</div><div class='col5'>Quantity Sold</div><div class='col6'>Unit Selling Price (Naira)</div><div class='col7'> Unit Cost Price (Naira)</div><div class='col8'>Unit Profit(Naira)</div><div class='col9'>Total Sales(Naira)</div><div class='col10'>Total Cost(Naira)</div><div class='col11'>Total Profit(Naira)</div><div class='col12'>Action</div></div>";
       
        for (i in myObj){

       txt +="<div class='row1'><div class='col1'>"+myObj[i].item_id+"</div><div class='col2'>"+myObj[i].items_description+"</div><div class='col3'>"+myObj[i].quantity_supplied+"</div><div class='col4'>"+myObj[i].quantity_available+"</div><div class='col5'>"+myObj[i].quantity_sold+"</div><div class='col6'>"+myObj[i].unit_selling_price+"</div><div class='col7'>"+myObj[i].unit_cost_price+"</div><div class='col8'>"+myObj[i].unit_item_profit+"</div><div class='col9'>"+myObj[i].total_selling_price+"</div><div class='col10'>"+myObj[i].total_cost_price+"</div><div class='col11'>"+myObj[i].total_profit+"</div><div class='col12'><button onclick='edit()'>Edit</button><button class='dle' onclick='del()'>Del</button><button class='sold' onclick='sold()'>+QSold</button><button class='supl' onclick='supplied()'>+QSupl</button></div></div>";
            
        txt +="<div class='row2'><form> <div class='col1'><input type='text' name='item_id' value='"+myObj[i].item_id+"'></div> <div class='col2'><input type='text' name='items_description' value='"+myObj[i].items_description+"'></div> <div class='col3'> <input type='text' name='quantity_supplied'  value='"+myObj[i].quantity_supplied+"'> </div> <div class='col4'><input type='text' name='quantity_available' value='"+myObj[i].quantity_available+"'></div> <div class='col5'><input type='text' name='quantity_sold' value='"+myObj[i].quantity_sold+"'></div> <div class='col6'> <input type='text' name='unit_selling_price' value='"+myObj[i].unit_selling_price+"'></div> <div class='col7'><input type='text' name='unit_cost_price' value='"+myObj[i].unit_cost_price+"'></div> <div class='col8'><input type='text' name='unit_item_profit' value='"+myObj[i].unit_item_profit+"'></div> <div class='col9'><input type='text' name='total_selling_price' value='"+myObj[i].total_selling_price+"'></div> <div class='col10'><input type='text' name='total_cost_price' value='"+myObj[i].total_cost_price+"'></div><div class='col11'><input type='text' name='total_profit' value='"+myObj[i].total_profit+"'></div> <div class='col12'><input type='button' name='svfm' onclick='save()' class='ed' id='edi' value='Save'></div> </form></div>";
            

       }

       document.getElementById("dis").innerHTML=txt; 
        
    }

  };

xmlhttp.open("POST", "rd.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("x=" + dbParam);


}


function readt() {

var obj, dbParam, xmlhttp, myObj, x, lmt,pl, txt = "";

obj = { "table":"bushara"};

document.getElementById("dis").innerHTML="Reading data .... Please wait";

dbParam = JSON.stringify(obj);

  if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
    } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange = function() {
    
    if (this.readyState == 4 && this.status == 200) {
       
        myObj = JSON.parse(this.responseText);

       for (i in myObj){

       txt +="<div class='row1'><div class='col1'>TOTAL All :</div><div class='col2'>"+myObj[i].number_of_item+"</div><div class='col3'>"+myObj[i].sum_quantity_supplied+"</div><div class='col4'>"+myObj[i].sum_quantity_available+"</div><div class='col5'>"+myObj[i].sum_quantity_sold+"</div><div class='col6'>"+myObj[i].sum_unit_selling_price+"</div><div class='col7'>"+myObj[i].sum_unit_cost_price+"</div><div class='col8'>"+myObj[i].sum_unit_item_profit+"</div><div class='col9'>"+myObj[i].sum_total_selling_price+"</div><div class='col10'>"+myObj[i].sum_total_cost_price+"</div><div class='col11'>"+myObj[i].sum_total_profit+"</div></div>";

       }

       document.getElementById("rdt").innerHTML=txt; 
        
    }

  };

xmlhttp.open("POST", "rdt.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("x=" + dbParam);


}


function subm(i,d,su,a,so,up,ucp,uip,tp,tcp,tsp) {
 
     var obj, dbParam, xmlhttp, myObj, x= " ";

     var i,d,su,a,so,up,ucp,uip,tp,tcp,tsp,sc='';

     var obj = { "items_description":d, "quantity_supplied":su, "quantity_available":a, "quantity_sold":so, "item_id":i, "unit_selling_price":up, "unit_cost_price":ucp,"unit_item_profit": uip,"total_profit": tp,"total_cost_price":tcp,"total_selling_price":tsp };
 
     //obj = { "firstname":f, "middlename":m, "lastname":l, "id":i };
 
     dbParam = JSON.stringify(obj);
 
     if (window.XMLHttpRequest) {
     // code for modern browsers

     xmlhttp = new XMLHttpRequest();

     } else {
     // code for IE6, IE5

     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

     }

     xmlhttp.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {

       myObj = JSON.parse(this.responseText);

       sc=myObj.success;

       document.getElementById("prn").innerHTML=sc; //myObj.success;
       read();
       readt();

      }   
    
   }; 
   
 xmlhttp.open("POST", "updw.php", true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send("x=" + dbParam);

 
 
 }



function del() {

        alert("Do you really want to delete this record?\n\nHit the DELETE button again to dalete."); 

        var dbParam, xmlhttp, myObj, obj= "";

        var dl = document.getElementsByClassName("dle");

        for ( i = 0; i < dl.length; i++) {

        dl[i].onclick=function(){

       // alert("how are you");

        var fg =this.parentNode.parentNode;

        var id = fg.firstChild.innerHTML;
                 
    
     document.getElementById("prn").innerHTML = 'deleting...';  //ids+","+nam+","+add+","+sal;
 
     obj = { "item_id":id};
 
     dbParam = JSON.stringify(obj);
 
     if (window.XMLHttpRequest) {
     // code for modern browsers

     xmlhttp = new XMLHttpRequest();

     } else {
     // code for IE6, IE5

     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

     }

     xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

        myObj = JSON.parse(this.responseText);

        var sc= document.getElementById("prn").innerHTML=myObj.success;

        //sc=myObj.success;

        //return sc;

       read();
       readt();
    }
    
   };
 
 xmlhttp.open("POST", "del.php", true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send("x=" + dbParam);

}

}   
                   
}


function next(){

    //document.getElementById("rst").innerHTML = adds();
    var nextpl = adds();
    read(nextpl,nextpl+10);
    

} 

   var adds = (function () {
   var counter = 0;
   return function () {return counter += 10;}
   })();
 
 

function previous(){
    
   //document.getElementById("rst").innerHTML = minus();
   //var nextmn = minus();
  // read();

}

 var minus = (function () {
    var count = 0;
   return function () {return count += 20;}
   })();




function updater(i,so) {

var obj, dbParam, xmlhttp, myObj, x= " ";

var so,i,sc='';

var obj = { "quantity_sold":so, "item_id":i /*"unit_selling_price":up ,"items_description":d, "quantity_supplied":su,*/};

//obj = { "firstname":f, "middlename":m, "lastname":l, "id":i };

dbParam = JSON.stringify(obj);

if (window.XMLHttpRequest) {
// code for modern browsers

xmlhttp = new XMLHttpRequest();

} else {
// code for IE6, IE5

xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

}

xmlhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {

  myObj = JSON.parse(this.responseText);

  sc=myObj.success;

  document.getElementById("rst").innerHTML=sc; //myObj.success;

 }   

}; 

xmlhttp.open("POST", "ss.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("x=" + dbParam);
       
   }

   function login(){

       document.getElementById("log").style.display="block";
   }

</script>


    
    <p align = 'right' style="margin-top:100px;"><a href="http://localhost/businesstransaction" target='_parent' class="btn btn-danger">Sign Out of Your Account</a></p>
    <!--<p align = 'right'><a href="logout.php" target='_blank' class="btn btn-danger">Sign Out of Your Account</a></p>-->
</body>
</html>