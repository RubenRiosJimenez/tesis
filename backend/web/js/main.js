$(function(){
	$('.modalButton-3').click(function(){
		$('#modal-3').modal('show')
			.find('#modalContent-3')
			.load($(this).attr('value'));
	});
});

$(function(){
    console.log("hola");

    $('.modalButton-4').click(function(){
		$('#modal-4').modal('show')
			.find('#modalContent-4')
			.load($(this).attr('value'));
	});

    $('#upload').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#img').attr('src', '/assets/no_preview.png');
        }
    });

});

$(function(){

});