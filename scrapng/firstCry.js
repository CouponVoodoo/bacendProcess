
var fs = require('fs');
var casper = require('casper').create({
    pageSettings: {
               // The WebPage instance used by Casper will
        loadImages: false ,         // use these settings
        javascriptEnabled: true
    }
});

var couponObj = [];
var url = casper.cli.get(0);
//var coupon_url = casper.cli.get(1);
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
var url2 = casper.cli.get(1);
//var url='http://www.firstcry.com/saps/saps-sleeveless-frock-with-polka-dots/180072/product-detail';
var coupon_url = url1 + url2;
//'http://54.243.150.171/getCouponCode.php?brand=firstCry';
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=';
var getList_url = getList + url2;
var ctl00_ContentPlaceHolder1_addtocart = "#ctl00_ContentPlaceHolder1_addtocart";
casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});

casper.options.stepTimeout=120000;
casper.options.waitTimeout = 100000;
//var couponInformations = '';


casper
  .thenOpen(coupon_url)    //opens the url of coupons


  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
	
  })
.thenOpen(getList_url)    //opens the url of coupons
  .then(function(){
 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace('</div></li></ol>','').replace(/&amp;/g, '&');

console.log(getListJson);
  })
  
  .thenOpen(url) 
  .then(function(){
    // scrape something
    
    this.echo(this.getTitle());
    if (this.exists(ctl00_ContentPlaceHolder1_addtocart)) {
        //this.echo('found #my_super_id', 'INFO');
    }  
    else {
    	this.echo('error');
    	var error = errorObject(2,'incorrect url');
    	couponObj.push(error);
    }

    
  })
  .thenClick(ctl00_ContentPlaceHolder1_addtocart)
  .then(function(){
	var SmallCartPanel = '#SmallCartPanel';
	var  btnPlaceOrder2 = '#btnPlaceOrder2';
 
 
 
  	casper.waitForSelector(SmallCartPanel, function() {
    
	})
  	.thenClick(btnPlaceOrder2)
  	.then(function(){


	})
	.thenOpen('https://secure.firstcry.com/fccheckout.aspx')
	.then(function(){
	

 		var d = this.evaluate(skippingToCouponStep);
 		var couponInformations = this.evaluate(couponPro, coupon_code);
    

    		casper.eachThen(couponInformations, function (response) {

    			var couponInformation = response.data;
    			
    			var initialDiscount= this.evaluate(function () 

			{
				return document.getElementsByClassName('smallcartitemcssremovecenterm')[0].innerHTML.replace('%', '').replace('-', '');
			});
       
    			var ListPrice= this.evaluate(function () 

			{
				return document.getElementsByClassName('smallcartitemcssremoverightm')[1].innerHTML.replace('-', '');
			});
        		var couponElement = this.evaluate(couponAutoClickFeature, couponInformation, 'txtCouponCode');
    
   			var x = require('casper').selectXPath;
   			this.thenClick(x('//*[@id="btnValidateCoupon"]'), function() {
    
			});
        
        
        
			this.waitFor(function check() {
				
        		var re = this.evaluate(couponClickCallback, couponElement, url,getListJson,initialDiscount,ListPrice);
         
           
			if (re != 'no' & re!='yes' & re!=null) {
                		couponObj.push(re);
                                                                                   
              
			}
            
			if (re != 'no'){
            	
	
           			var x = require('casper').selectXPath;
           			if (this.exists(x('//*[@id="btnRemoveFCCoupon"]'))){
   
					this.thenClick(x('//*[@id="btnRemoveFCCoupon"]'), function() 

{
    
						
					});
				}
            	
        
			
        		re = 'found';
            		}
            		return re == 'found';
            		this.evaluate(function () {
                		
                		return re != 'no';
            		});
            
            
        		}, function then() {
        
            
				
          
				this.waitFor(function checkLoadingDiv() {
					var UpdateProgress1 = 'UpdateProgress1';
                			
                			var re = this.evaluate(checkLoading, UpdateProgress1);
                
                			function checkLoading(UpdateProgress1) {
    						try {
       
          
							var check = document.getElementById(UpdateProgress1).style.display;
  
  							if (check == 'block'){
	
        							return 'no';
							}
    						} catch (e) {console.log('close error '+e.message);}
    					return 'yes';

					}
               
                			
                
                			return re === 'yes';
                			this.evaluate(function () {
                    				
                    				return re === 'yes';
                			});
            
				}, function then() {
                
					
            
					});
          

        
			});


    
		});


	});
  

})





casper.run(function () {
	
	var abc = couponObj;
	

	var finalResult = this.evaluate(otherCodesString, abc);
	function otherCodesString(abc) {
		try{

			
	
			abc.sort(function (a, b) {
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
                     
   			if (parseInt(abc[0][0].Saving) >0){
   
   			abc[0][0].BestCoupon = 1;}
                              return abc;
		}catch(e){console.log(e.message);} 
	}  



 
	
	if (JSON.stringify(finalResult)=='null' )
{this.echo('['+JSON.stringify(couponObj).replace(/]/g,'').replace(/\[/g,'')+']');
}  //to print the coon allpied
else
{
this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']'); 
} //to print the cupon allpied
this.exit();
});




function errorObject(ErrorCode,Description) {
                        var appliedCouponObj = [];
                        appliedCouponObj.push({
                            'ErrorCode': ErrorCode,
                            'Description': Description
                            
                        })
                        return appliedCouponObj;
                    }





function couponPro(coupon_code) {
      var couponInformation = JSON.parse(coupon_code);


      return couponInformation;
   
}


function couponAutoClickFeature(couponInformation, couponTextInputDiv) {
   
     try {
    	
        
        var couponElement = couponInformation;
        var couponCode = couponElement.couponcode;
        var couponDes = couponElement.description;
        var elem = document.getElementById(couponTextInputDiv);
        elem.value = couponElement.couponcode;
        
        
        var source = couponElement.source;
              
    } catch (e) {
        console.log(e.message);
    }
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
        console.log('erroe..' + e.message);
    }

}




function couponClickCallback(couponElement, url,getListJson,initialDiscount,ListPrice) {
	console.log('iiiiiiiiiiiiiiiiiiiiiiiiiii'+initialDiscount);
	var lblInvalidCoupon = 'lblInvalidCoupon';
console.log(couponElement.couponcode);
	var tolTipCouponinner='smallcartitemcssremovecenterm';
	var txtFCCoupondisocunt = 'txtFCCoupondisocunt';
     	var btnRemoveFCCoupon = 'btnRemoveFCCoupon';
	var check = $('#txtCouponCode').css('backgroundImage');
console.log(check);
	if (check.indexOf('ajax-loader.gif')>-1){
	
        return 'no';
	}
	else {console.log(document.getElementsByClassName(tolTipCouponinner)[0].innerHTML.replace('-Rs. ', '').replace('-', ''));
	        if (document.getElementById('lblInvalidCoupon').innerHTML !=''){
 
	
            
			try{      	
 console.log('iffffff');
        	var saving = document.getElementById(lblInvalidCoupon).innerHTML;
                  		
                if (saving.indexOf('Invalid') == -1 || saving.indexOf(couponElement.couponcode) > -1 ){
                  	
 var saving = document.getElementById(lblInvalidCoupon).innerHTML;
console.log('sss'+saving);		
   var obj = updateSuccessfulCoupon(couponElement.couponcode,saving,couponElement.description,document.domain,url,0,getListJson);		

                  		}
            		}catch(e){console.log(e.message);}
        	}

                  		

		else {console.log('elseeeee');
                  		
                  			
			try{
               var suc = 1;   	                  		
var saving = document.getElementsByClassName(tolTipCouponinner)[0].innerHTML.replace('%', '').replace('-', '');
console.log(saving); 
if (saving == '0' || saving == 0 || saving ==initialDiscount){
	 console.log('NA');
	saving = document.getElementById('lblInvalidCoupon').innerHTML;
	 suc = 0;
}
else {netPrice = document.getElementsByClassName('smallcartitemcssremoverightm')[1].innerHTML.replace('-', '');
	 console.log('inside'+ListPrice);
	saving = Math.floor(ListPrice-netPrice);}
	console.log(saving); 
var obj = updateSuccessfulCoupon(couponElement.couponcode,saving,couponElement.description,document.domain,url,suc,getListJson);		

	//document.getElementById(btnRemoveFCCoupon).click();
                         			
			}catch(e){console.log(e.message);}
                  		
		}
                  		
                  		
                  		
                  	
		return obj;
                  	
            
		function extractRetailerNameFromDocDomain(docDomain) {
          		if (docDomain==null){return null;}
          		var domainSplitArr = docDomain.split(".");
          
          		if (domainSplitArr == null || !(domainSplitArr.length > 0))
              			return docDomain;
          		var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          		if (check == 'co.in') {
              			return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          		}
          		if (docDomain == 'www.google.co.in') return 'google';
          		return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
      		}
            	           function updateSuccessfulCoupon(couponCode, saving, couponDescription,domain,url,Successful,getListJson) 
								{
url=url.split("?")[0];
var getList = JSON.parse(getListJson);	
//console.log(getList);
var affiliate  =  getList.ActiveAffiliate;

//console.log('--------------------------->'+affiliate.toLowerCase());	
if (affiliate.toLowerCase()=='omg')
{
var url = getList.URLpart1+'?&uid1='+couponCode+'&uid2=couponVoodoo&uid3=live&redirect='+escape(escape(url+getList.URLpart2));}
else if (affiliate.toLowerCase()=="tyroo" || affiliate.toLowerCase()=='komli') {
var url = getList.URLpart1+'&lnkurl='+escape(escape(url+getList.URLpart2))+'&subid1='+couponCode+'&subid2=couponVoodoo&subid3=live';

} 				
else if (affiliate.toLowerCase().indexOf('dgmpro')>-1) 
{
var url = getList.URLpart1+'?&k='+couponCode+'|couponVoodoo|live&t='+escape(escape(url+getList.URLpart2));
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


function skippingToCouponStep() {
var Login1='Login1';
var tab2= 'tab2';
try{
	
	document.getElementById(Login1).style.display='none';
	document.getElementById(tab2).style.display='block';
	
}catch(e){console.log("error "+e.message);}
return 'done';
}

