/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
$("form.empty-filter").submit(function(){
 $(this).find('input,select').filter(function() {
      return this.value === ''
 }).prop("disabled", true);   
 $(this).find('input[type="submit"]').removeAttr("name");
});
}
);

