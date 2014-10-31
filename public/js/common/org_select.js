/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
   $("input[data-role='multiselect-remote']").each(function(){
      var url=$(this).attr("data-link");
      var placeholder=$(this).attr("placeholder")||$(this).attr("data-placeholder");
       $(this).select2({
    placeholder: placeholder,
   minimumInputLength: 3,
 //containerCssClass:'col-md-12',
    width:'100%',
    multiple:true,
    closeOnSelect:true,
     maximumSelectionSize: 5,
initSelection:function (element, callback) {
        var id=$(element).val();
        if (id!=="") {
            $.ajax(url, {
                data: {
                    autocomplete:1,
                    val: id
                },
                dataType: "json"
            }).done(function(data) {
             var result=[];
                $.each(data,function(){
                var text=this.name;
                result.push({id:this.id,text:text});
            });   
            callback(result); });
        }  
    },

    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url: url,
        dataType: 'json', 
        data: function (term) {
            return {
                autocomplete:1,
                query: term
                            };
        },
     
        results: function (data) {
            var result=[];
            $.each(data,function(){
                var text=this.name;
                result.push({id:this.id,text:text});
            });
            return {
                results:result
            };
        }
   }
});
   });  
});

