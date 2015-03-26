var page = require('webpage').create();
var system = require('system');

page.settings.resourceTimeout = 45000; // 5 seconds
page.onResourceTimeout = function(e) {
  //console.log(e.errorCode);   // it'll probably be 408 
  //console.log(e.errorString); // it'll probably be 'Network timeout on resource'
  //console.log(e.url);         // the url whose request timed out
 // phantom.exit(1);
};



page.onConsoleMessage = function(msg){
    console.log(msg);
};

var url= '';
var productCount = 1500;

if (system.args.length === 1) {
    console.log('Try to pass some args when invoking this script!');
} else {
    system.args.forEach(function (arg, i) {
      //      console.log(i + ': ' + arg);
if(i == 1)
    {
        url= arg;
//console.log(url);
    }
if(i == 2)
    {
        productCount= arg;
//console.log(url);
    }

    });

}
//var productCount = 20;
var prevProducts=0;
var k=0;
var currentTime=0;
//console.log(url+' '+productCount);
var url = 'http://www.snapdeal.com/products/electronics-speakers?sort=plrty&';
page.open(decodeURIComponent(url), function () {
console.log(decodeURIComponent(url));
currentTime=page.evaluate(function() {
return Math.round(new Date().getTime() / 1000);
});

  // Checks for bottom div and scrolls down from time to time
  window.setInterval(function() {

      // Checks if there is a div with class=".has-more-items" 
      // (not sure if this is the best way of doing it)
      var count = page.evaluate(function() {
try{       

var element = document.getElementsByClassName("productWrapper");
var numberOfChildren = element.length;
//return (numberOfChildren);
var results = document.getElementById('resultsOnPage').getAttribute('value');


//results = results-4;
var validPage=document.getElementById('filter-no-results-message1');
//return (results==null);
if (validPage) {
return 'exit';
}

if (numberOfChildren<results || results==0 || results==null){
 return 'block';
}
else return none;
}catch(e){return e.message;}
    });
//count = 1

 console.log('1111 '+count);

if (count == 'exit') {
 phantom.exit();
}
var time = Math.round(new Date().getTime() / 1000);
var duration = time-currentTime;
console.log(duration);
if (duration > 2400){
count='none';
}
      if(count == 'block' || count == '' ) { // Didn't find


      console.log('count '+count);
//this.echo('wdc');      
page.evaluate(function() {

          // Scrolls to the bottom of page

        

 window.document.body.scrollTop = document.body.scrollHeight;

         

        });
      }
      else { // Found
        //Do what you want
//console.log('len123');
     
            try {
            
  	var links = page.evaluate(function() {
        return [].map.call(document.querySelectorAll('.productWrapper'), function(link) {
//console.log('link');
        	var pageUrl = link.getElementsByClassName('product-title')[0].getElementsByTagName('a')[0].getAttribute('href');
        	
            var ProductImageDiv = link.getElementsByClassName('product-image ')[0].getElementsByTagName('a')[0].getElementsByTagName('img')[0];
            //console.log('ProductImageDiv '+ProductImageDiv);
            if (typeof(ProductImageDiv)==='undefined'){
            	var ProductImage='null';
            	
            }
            else {var ProductImage=ProductImageDiv.getAttribute('src');}
            var listPrice = link.getElementsByClassName("product-price")[0].innerText.replace('Rs ','').trim();
            if (listPrice==''  || listPrice == null ){
            var listPrice = link.getElementsByClassName("product-price")[0].getElementsByTagName('div')[0].innerText.replace('Rs ','').trim();
}

            var MrpDiv = link.getElementsByClassName("product-price")[0].getElementsByTagName('strike')[0];
            
            var brandName = ''; 
            var productName=link.getElementsByClassName('product-title')[0].getElementsByTagName('a')[0].innerHTML.replace('"',' ').trim();
            if(typeof(MrpDiv) === 'undefined'){
            	var Mrp = listPrice;
 				}
 			else {
 				var Mrp = MrpDiv.innerText.replace('Rs ','').trim();
if (listPrice.indexOf(")")>1){
listPrice=listPrice.split(")")[1].replace('Rs ','').trim();
}
 			}
 return '{"PU":"'+pageUrl+'","PI":"'+ProductImage+'","LP":"'+listPrice+'","Mrp":"'+Mrp+'","B":"'+brandName+'","PN":"'+productName+'"}';
        });});
         } catch (e) {
           
           console.log(e.message); return [];
            }
        
console.log(links.join('||'));
//var result = links.join('||');
        phantom.exit();
      }
var numOfProducts = page.evaluate(function() {
	var element = document.getElementsByClassName("productWrapper");
var numberOfChildren = element.length;
return numberOfChildren; 
});
console.log('numberOfProducts '+numOfProducts+ ' > '+productCount +' prevProducts ='+ prevProducts);
if (prevProducts==numOfProducts){
k=k+1;
console.log('k = '+ k);
}
else {
console.log('.....');
k=0;
prevProducts=numOfProducts;
console.log (prevProducts);
}

if (numOfProducts > productCount || k>=8 || numOfProducts==0){//console.log('adfad');
	console.log('-------------------------------');
	var links = page.evaluate(function() {
        return [].map.call(document.querySelectorAll('.productWrapper'), function(link) {
//console.log('link');
        	var pageUrl = link.getElementsByClassName('product-title')[0].getElementsByTagName('a')[0].getAttribute('href');
        	
            var ProductImageDiv = link.getElementsByClassName('product-image ')[0].getElementsByTagName('a')[0].getElementsByTagName('img')[0];
            //console.log('ProductImageDiv '+ProductImageDiv);
            if (typeof(ProductImageDiv)==='undefined'){
            	var ProductImage='null';
            	
            }
            else {var ProductImage=ProductImageDiv.getAttribute('src');}
            var listPrice = link.getElementsByClassName("product-price")[0].innerText.replace('Rs ','').trim();
            if (listPrice==''  || listPrice == null ){
            var listPrice = link.getElementsByClassName("product-price")[0].getElementsByTagName('div')[0].innerText.replace('Rs ','').trim();
}

            var MrpDiv = link.getElementsByClassName("product-price")[0].getElementsByTagName('strike')[0];
            
            var brandName = ''; 
            var productName=link.getElementsByClassName('product-title')[0].getElementsByTagName('a')[0].innerHTML.replace('"',' ').trim();
            if(typeof(MrpDiv) === 'undefined'){
            	var Mrp = listPrice;
 				}
 			else {
 				var Mrp = MrpDiv.innerText.replace('Rs ','').trim();
if (listPrice.indexOf(")")>1){
listPrice=listPrice.split(" ")[0].replace('Rs','').trim();
}
return listPrice+'---'+Mrp; 			}
 return '{"PU":"'+pageUrl+'","PI":"'+ProductImage+'","LP":"'+listPrice+'","Mrp":"'+Mrp+'","B":"'+brandName+'","PN":"'+productName+'"}';
        });});
   
	
	
	console.log(links.join('||'));phantom.exit();
	
}
else {



}
  }, 1500); // Number o ms to wait between scrolls

});