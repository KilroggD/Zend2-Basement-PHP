/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function stickyFooter(){
       console.log($("body").height());
   console.log($(window).height());
   if ($("body").height() <= $(window).height())
	$("footer").addClass("navbar-fixed-bottom");
}


var RCP={
    Program:{
        Form:{
            Add:{
            },
            Edit:{

            },
            Elements:{
                
            }
        }
    },
    //валидаторы
    Validator:{
        
    },
    //хелперы (рассчет финансирований и т д)
    Helper:{
        
    }
    
};

$(document).ready(function(){
   $("a[data-role='confirm-delete']").each(function(){
      var item=$(this).attr("data-item");
      $(this).bind("click",function(){
         return confirm("Вы действительно хотите удалить "+item+"?"); 
      });
   });
   $("a[data-role='confirm-link']").bind("click",function(){
      var message=$(this).attr("data-message"); 
      return confirm (message);
   });
//stickyFooter();
});