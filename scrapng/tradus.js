var fs = require('fs');
var casper = require('casper').create({
    pageSettings: {
               // The WebPage instance used by Casper will
        loadImages: true ,         // use these settings
        javascriptEnabled: true
    }
});

casper.on('remote.message', function (msg) {
    this.echo(msg);
});
var couponObj = [];
var url = casper.cli.get(0);
//var url = 'http://www.tradus.com/oleva-pearl-watch/p/WATMBQBSWG68EHRN';
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
//var url2 = casper.cli.get(1);
var url2 = 'tradus';
var coupon_url = url1 + url2;
var gelLoginCredentialsUrl = 'http://54.243.150.171/getLoginCredentials.php';
var coupon_code;
var loginCredentialsArr;
casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});
casper.options.waitTimeout = 20000;

 casper.open('http://54.243.150.171/getLoginCredentials.php')    //opens the url of coupons
  .then(function(){

    var loginCredentialsJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
    loginCredentialsArr = JSON.parse(loginCredentialsJson);
    console.log(loginCredentialsJson);
	
  })

  .thenOpen(url) 
  .then(function(){
    // scrape something
    
    this.echo(this.getTitle());
  
  var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="buy-now-desktop"]'), function() {
	this.thenOpen('http://www.tradus.com/cart');
	this.capture('adcart.png');
    
});
  });
  //var x = require('casper').selectXPath;
 casper.then(function(){
  
  casper.waitForSelector('.tradus-order-shopmore-button', function() {
   var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="viewport"]/div[2]/div/div[2]/div/div/div[2]/div[4]/div[5]/a[2]'), function() {
   this.capture('before1.png');
});

casper.waitForSelector('#login-main', function() {

this.capture('before.png');
casper.start('<https://www.tradus.com/login?dest_url=https://www.tradus.com/cart/select-address>', 

function() {
this.fill('form#user-login', {
        'form_submit':    1,
        'name':    'lavesh626@gmail.com',
        'pass':   '1234rewq',
        'op':       'Log in'

    }, true);

  casper.thenOpen('http://54.243.150.171/getCouponCode.php?brand=tradus')    //opens the url of coupons
  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
	
  })
  
casper.thenOpen('https://www.tradus.com/cart/select-address') 
.then(function(){

this.capture('start.png');
});
casper.waitForSelector('.tradus-address-holder', function() {



 var couponInformations = this.evaluate(couponPro, coupon_code);
 this.capture('start1.png');
    var x = require('casper').selectXPath;
  // this.thenClick(x('/html/body/div[3]/div[2]/div[2]/div[3]/a[1]'), function() {
    
  this.thenClick(x('//*[@id="viewport"]/div[2]/div[1]/div[2]/div[1]/div[2]/div[2]/div[3]/a[1]'), function() {
   this.capture('afterproceed.png');


        casper.eachThen(couponInformations, function (response) {

    var couponInformation = response.data;
        this.capture('checkerr.png');
        var couponElement = this.evaluate(couponAutoClickFeature, couponInformation, 0, 'coupon_code', 'couponBtn', 'resultMessage', 'domainElement');
   var x = require('casper').selectXPath;
   this.capture('start3.png');
   //this.thenOpen('https://www.tradus.com/cart/checkout/review');
var itemXpath = '//*[@id="viewport"]/div[2]/div/div[2]/div/div/div[2]/div[2]/div[1]/div[1]/form/p/a';
if (this.exists(x(itemXpath))) { itemXpath = itemXpath ;} 
else {itemXpath = '//*[@id="viewport"]/div[2]/div/div[2]/div/div/div[2]/div[4]/div[1]/div[1]/form/p/a';}
   this.thenClick(x(itemXpath), function() {
   
    
});
        this.capture('checkerrcheck.png');
        
        this.waitFor(function check() {
           
           
            var re = this.evaluate(couponClickCallback, couponElement, 'couponCode', 'bt-coupon', 'resultMessage', 'domainElement', url);
           console.log(JSON.stringify(re));
           if (re != 'no' & re!='yes' & re!=null) {
           	
                couponObj.push(re);
                
                
            }
            if (re != 'no'){
            	
        re = 'found';
            }
            return re == 'found';
            this.evaluate(function () {
                
                return re != 'no';
            });
            
            
        }, function then() {
       
          
        });


    });

});
});
this.capture('beforeproceed.png');
 var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="viewport"]/div[2]/div/div[2]/div/div/div[2]/div[2]/div[1]/div[2]/div[1]/div[2]/a'), function() {
   
});

});
})
  

});
  

})


casper.run(function () {
this.capture('run.png');
 var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="viewport"]/div[2]/div/div[2]/div/div/div[2]/div[2]/div[1]/div[2]/div[1]/div[2]/a'), function() {
    });
var finalResult = this.evaluate(otherCodesString, couponObj);
function otherCodesString(couponObj) {
try{

	couponObj.sort(function (a, b) {
    a = +a[0].Saving, b = +b[0].Saving; // cast Number
    // special cases
    if (a !== a) { // if `a` NaN
        if (b !== b) return 0; // both NaN; no action
        return 1; // move it to end
    }
    if (b !== b) // if `b` NaN
        return -1; // move it to end
    // classic descending sort
    return b - a;
});
                     
   if (parseInt(couponObj[0][0].Saving) >0){
   
   couponObj[0][0].BestCoupon = 1;}
                              return couponObj;
}catch(e){} 
}   
//this.echo(finalResult);
this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']');
this.exit();
});


function couponPro(coupon_code) {

    
  try{
  document.getElementsByClassName('tradus-select-user-address-page2')[0].style.display='block';
  document.getElementsByClassName('tradus-select-address-checkbox')[0].getElementsByTagName('input')[0].checked = 'checked';
  //document.getElementById('ShippingAddress856425').checked = 'checked';
      var couponInformation = JSON.parse(coupon_code);
}catch(e) {console.log(e.message);}
return couponInformation;
   
}


function couponAutoClickFeature(couponInformation, i, couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv,domainElement) {
   
        try {
    	
           var couponElement = couponInformation;
        var couponCode = couponElement.couponcode;
        var couponDes = couponElement.description;
        var elem = document.getElementsByClassName('redeem-voucher-value')[0].getElementsByTagName('input')[0];
        elem.value = couponElement.couponcode;
        document.getElementsByClassName('redeem-btn')[0];
        var source = couponElement.source;
              
    } catch (e) {
        console.log(e.message);
    }
    //                 return document.getElementById(couponTextInputDiv).value;
   console.log(elem.value);      	
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
        console.log('erroe..' + e.message);
    }

}

function couponClickCallback(couponElement,  couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv, domainElement, url) {
    
  //console.log(check);
//console.log(document.getElementsByClassName('redeem_msg_lol')[0].innerHTML);
//console.log(document.getElementsByClassName('redeem-voucher-value')[0].innerHTML);
    var check = document.getElementsByClassName('redeem_msg_lol')[0];
    //console.log('check '+check.innerHTML);
//changed by me
   //var check = document.getElementsByClassName('redeem_msg_lol')[0].getElementsByTagName('input')[0];
//this.capture('endd.png');
 
if (check == null){

        return 'no';
}
else {
       try{ 
		var checkIfValidCoupon = check.innerHTML;
 
        if (checkIfValidCoupon.indexOf('check voucher details') >-1 ){
 
	
            try{      	
 
        var saving = checkIfValidCoupon.split('To check')[0];
             var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,0);			
            console.log(JSON.stringify(obj));
            return obj;
                  	    }catch(e){return e.message;}
        }
                  		else if (checkIfValidCoupon.indexOf('call') >-1 ){
                  		
                  			try{
                  		
                  	
                  var saving = 'Valid Coupon!!! Please try the coupon manually to unlock the saving';
                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1);			 		
                  		 	return obj;
                  		
                  
                  			}catch(e){return e.message;}
                  		}
                  		
                  		else if (checkIfValidCoupon.indexOf('Congratulations') >-1 ){
                  		
                  			try{
                  		
                  	
                  var saving = Math.round(parseInt(document.getElementsByClassName('order-summary-value')[5].innerHTML.replace('Rs. ','').replace(',','')));
                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1);			 		
                  		
                  		 	return obj;
                  			}catch(e){return e.message;}
                  		}
                  		else {
                  		
                  			try{
                  		
                  	
                  var saving = checkIfValidCoupon;
                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,document.referrer,0);			 		
                  		 	return obj;
                  		
                  			}catch(e){return e.message;}
                  		}
                  		
       }catch(e){}
                  	return obj;
                  	
            function extractRetailerNameFromDocDomain(docDomain) {
          if (docDomain==null){return null;}
          var domainSplitArr = docDomain.split(".");
          
          if (domainSplitArr == null || !(domainSplitArr.length > 0))
              return docDomain;
          var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr

[domainSplitArr.length - 1];
          if (check == 'co.in') {
              return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr

[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          }
          if (docDomain == 'www.google.co.in') return 'google';
          return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr

[domainSplitArr.length - 1];
      }
            function updateSuccessfulCoupon(couponCode, saving, 

couponDescription,domain,url,Successful) {
                        var appliedCouponObj = [];
                        appliedCouponObj.push({
                            'couponCode': couponCode,
                            'Saving': saving,
                            'description': couponDescription,
                            'Successful':Successful,
                            'domain':domain,
                            'url':url,
                            'BestCoupon':0
                        })
                        return appliedCouponObj;
                    }
       
    }

}

function close() {
var pgLoading= "pgLoading cartPagePgLoading";
var removeMask = "removeMask";
var cartoption = "cart-new-pay-option"; 
    try {
 
 if (document.getElementsByClassName(pgLoading)[0].style.display=='block')

{return 'no';}
 if (document.getElementById(removeMask).style.display=='block'){
 	document.getElementById(removeMask).style.display='none';
 	document.getElementById(cartoption).style.display='block';
 	return 'no';}
       
      
        var a = document.getElementById("gift-close");
        
        if (a != null) {


        }
        $('#gift-close').click(function () {

            // prepare an action here, maybe say goodbye.
            //
            // if #tray-arrow is button or link <a href=...>
            // you can allow or disallow going to the link:
            // return true; // accept action
            // return false; // disallow 
        });


    } catch (e) {console.log('close error '+e.message);}
    return 'yes';

}
