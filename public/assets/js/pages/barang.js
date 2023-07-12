$(document).ready(function(){
    $(".delete-barang").click(function(e){
        e.preventDefault();
        var yakin = confirm("Yakin ingin menghapus barang ini ?");
        if(!yakin) return;

        location.href = $(this).attr('href');
    });
});