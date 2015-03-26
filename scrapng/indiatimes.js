var fs = require('fs');
var casper = require('casper').create({
    pageSettings: {
               // The WebPage instance used by Casper will
        loadImages: true ,         // use these settings
        javascriptEnabled: true
    },
onAlert : function(){ //what to do if timeout reaches?

       // this.echo('Alert found');       
    },
onTimeout : function(){ //what to do if timeout reaches?

//        this.echo('Alert found');       
    

}
});

casper.on('remote.message', function (msg) {
    this.echo(msg);
});
var couponObj = [];
var url = casper.cli.get(0);
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=indiatimesshopping';
var url2 = casper.cli.get(1);
var coupon_url = url1 ;
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=indiatimes';
var getList_url = getList ;
var coupon_code = '';

casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});
casper.options.stepTimeout=120000;
casper.options.timeout = 120000;
casper.options.waitTimeout = 10000;
//var couponInformations = '';
casper
  .thenOpen(coupon_url)    //opens the url of coupons
  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
//console.log(coupon_code);
  })
.thenOpen(getList_url)    //opens the url of coupons
  .then(function(){
 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace('</div></li></ol>','').replace(/&amp;/g, '&');

//console.log(getListJson);
  })

  .thenOpen(url) 
  .then(function(){
    // scrape something
    
    this.echo(this.getTitle());
 this.capture('indiatimes1.png'); 
  
  });
 
  var x = require('casper').selectXPath;
  casper.thenClick(x('//*[@id="buyNow"]'), function() {
 this.capture('indiatimes2.png'); 
 
 this.echo(this.getHTML('#overeffect'));
//this.echo(this.getHTML('#product_addtocart_form'));
 //console.log('gt ittttttttttttttttttttttttttttttttttttttttttttttt');
 
 casper.waitForSelector('#TB_conHolder', function() {
   console.log('------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>');
this.capture('indiatimes25.png');
//console.log('llllllllllllll'+this.getCurrentUrl());
//this.echo(this.getHTML('#TB_conHolder'));
  //console.log(this.getElementsInfo('#TB_window'));
 var d = this.evaluate(skippingToCouponStep);
 var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="gccalculator_loggedIn"]/div[1]'), function() {
    console.log("Woop Click!");
});
 var couponInformations = this.evaluate(couponPro, coupon_code);
  //  console.log('couponInformations'+couponInformations);

 this.capture('indiatimes3.png'); 
casper.eachThen(couponInformations, function (response) {

    var couponInformation = response.data;
      //  console.log('couponInformation ' + couponInformation);
        var couponElement = this.evaluate(couponAutoClickFeature, couponInformation, 0, 'coupon_code', 'couponBtn', 'resultMessage', 'domainElement');
    //console.log("val "+couponElement);
   var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="gccalculator_loggedIn"]/div[2]/input[2]'), function() {
    console.log("Woop Click!");
});
        
      //  console.log('couponElement');
        this.waitFor(function check() {
            console.log('yoyoyoy');
          // console.log('...................................'+getListJson);
            var re = this.evaluate(couponClickCallback, couponElement, 'couponCode', 'bt-coupon', 'resultMessage', 'domainElement',url, getListJson);
         //  console.log('reeeeeeeeeec '+re);
           if (re != 'no' & re!='yes' & re!=null & re != '') {
                couponObj.push(re);
                
               // console.log('result ' + JSON.stringify(couponObj));
            }
            if (re != 'no' & re!=null) {
            	 var x = require('casper').selectXPath;
   this.thenClick(x('//*[@id="carttab_content"]/div[3]/div[1]/div/div[5]/input'), function() {
    console.log("Woop Click!");
});
            	//=============================
   
            	//=============================
        console.log('outer '+re);
        re = 'found';
            }
            return re == 'found';
            this.evaluate(function () {
                console.log('inside 3');
                return re != 'no';
            });
            
            
        }, function then() {
        //	 console.log('result ' + JSON.stringify(couponElement));
            console.log('dcfd')
          
        });


    });



});
  

})


casper.run(function () {
console.log('addressssssssssssss'+this.getCurrentUrl());
 this.capture('indiatimesRun.png'); 
 //var x = require('casper').selectXPath;
   //this.thenClick(x('/html/body/div[1]/div[1]/div[3]/div[2]/div[1]/div[2]/div[1]/div[2]/a'), 


var finalResult = this.evaluate(otherCodesString, couponObj);
function otherCodesString(couponObj) {
try{console.log('sorting');
var atec = couponObj;
//console.log('result ' + couponObj);
	atec.sort(function (a, b) {
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
 

    
  
      var couponInformation = JSON.parse(coupon_code);

return couponInformation;
   
}


function couponAutoClickFeature(couponInformation, i, couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv,domainElement) {
    console.log('testing...couponAutoClickFeature');
    try {
    	
       // console.log(JSON.stringify(couponElement));
        var couponElement = couponInformation;
        //  console.log(JSON.stringify(couponElement));
        var couponCode = couponElement.couponcode;
        console.log(couponCode);
        var couponDes = couponElement.description;
        var elem = document.getElementById('checkgctxt');
        elem.value = couponElement.couponcode;
        console.log(couponCode+' elem '+elem.value);
        //document.getElementsByClassName('back2saved-add')[0].click();

        var source = couponElement.source;
              
    } catch (e) {
        
    }
    //                 return document.getElementById(couponTextInputDiv).value;      	
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
       // console.log('erroe..' + e.message);
    }

}

function couponClickCallback(couponElement, couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv, domainElement,url,getListJson) {
   // console.log('couponClickCallback...........'+getListJson);
  //  console.log(JSON.stringify(couponElement));
    //---------------------------------------------------
    //                             clearInterval(myVar);
    //       return 'yes';
  
    var check = document.getElementById('updating');
 
if (check.style.display == 'block'){

        return 'no';
}
else {
       try{ //console.log('else '+check.innerHTML);
		var checkIfValidCoupon = document.getElementById('checkGCError');
        var savingCouponDiv = document.getElementsByClassName('gccalculator_txt1_redeemed')[0];
        if (checkIfValidCoupon.style.display == 'block' ){
 
	if ( checkIfValidCoupon.innerHTML.indexOf('incorrect') >-1) {return null;}
            try{      	
 
        var saving = checkIfValidCoupon.innerHTML;
        //return saving;
                  		//console.log('saving '+saving);
                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,0,getListJson);			
                  	//	document.getElementById('tab-coupon').style.display='block';
            }catch(e){return '';}
        }
                  		else if (savingCouponDiv.style.display == 'block' ){
                  		
                  			try{
                  		
                  	
                  var saving = Math.round(parseInt(document.getElementById('totalDiscount').innerHTML.replace('`','')));

                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1,getListJson);			 		
                  		
                  		//console.log('inside '+JSON.stringify(obj));
                  
                  			}catch(e){return e.message;}
                  		}
                  		
                  		else if (checkIfValidCoupon.indexOf('Congratulations') >-1 ){
                  		
                  			try{
                  		
                  	
                  var saving = document.getElementsByClassName('order-summary-value')[5].innerHTML;
                  var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1,getListJson);			 		
                  		
                  		//console.log('inside '+JSON.stringify(obj));
                  
                  			}catch(e){return '';}
                  		}
                  		
                  		
       }catch(e){return '';}
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
            function updateSuccessfulCoupon(couponCode, saving, couponDescription,domain,url,Successful,getListJson) 

			{
url=url.split("?")[0];
			//console.log('-------->'+getListJson);		

var getList = JSON.parse(getListJson);	
//console.log(getList);
var affiliate  =  getList.ActiveAffiliate;

//console.log('--------------------------->'+affiliate.toLowerCase());	
if (affiliate.toLowerCase()=='omg')
{
var url = getList.URLpart1+'?&uid1='+couponCode+'&uid2=couponVoodoo&uid3=live&redirect='+escape
(escape(url+getList.URLpart2));}
else if (affiliate.toLowerCase()=="tyroo" || affiliate.toLowerCase()=='komli') {
var url = getList.URLpart1+'&lnkurl='+escape(escape(url+getList.URLpart2))+'&subid1='+couponCode+'&subid2=couponVoodoo&subid3=live';

} 				
else if (affiliate.toLowerCase().indexOf('dgmpro')>-1) 
{
var url = getList.URLpart1+'?&k='+couponCode+'|couponVoodoo|live&t='+escape(escape(url
+getList.URLpart2));
}
                        
									var appliedCouponObj = [];
                        						appliedCouponObj.push(

							{
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
    try {console.log('start close');
        //
 //console.log('close '+document.getElementsByClassName("pgLoading cartPagePgLoading")[0].style.display);   
 if (document.getElementsByClassName("pgLoading cartPagePgLoading")[0].style.display=='block')

{return 'no';}
 if (document.getElementById("removeMask").style.display=='block'){
 	document.getElementById("removeMask").style.display='none';
 	document.getElementById("cart-new-pay-option").style.display='block';
 	return 'no';}
       
        //    clearInterval(finalClose);
        var a = document.getElementById("gift-close");
        console.log('gift close ' + a);
        if (a != null) {

            //document.getElementById('gift-close').onClick();
            //		 $("#gift-close")[0].click();

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
function skippingToCouponStep() {try{
	console.info(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");
	console.log(document.getElementById('overeffect').style.display);
	//document.getElementsByClassName('gccalculator_txt2')[0].style.display ='block';
	
}catch(e){}
return 'done';
}

function test(test){

var url = document.getElementById('product_addtocart_form').action;	

	return url;
}
	;