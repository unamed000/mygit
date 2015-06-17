/**
 * Created by gento on 22/5/2015.
 */
var process_result = function(result){
  if(result.status == REQUEST_SUCCESS){
      swal({
          title: "Success",
          text: angular.isUndefined(result.message)?'The request is completed':result.message,
          type: "success",
          html: true
      });
}else{
      swal({
          title: "Error",
          text: angular.isUndefined(result.message)?'The request is failed':result.message,
          type: "error",
          html: true
      });
  }
};