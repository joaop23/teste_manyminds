<div class="modal" tabindex="-1" id="modalLog" name='modalLog'>
    <input type="hidden" name="idComponente" id="idComponente" value=""/>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sistema de Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table table-striped table-bordered text-center" id='tableProdutos' name='tableProdutos'>
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">DATA/HORA</th>
                    <th scope="col">OPERACAO</th>
                    <th scope="col">USUARIO</th>
                    <th scope="col">NR IP</th>
                </tr>
                </thead>
                <tbody id="bodyLog">
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
$(document).on("click", ".open-AddBookDialog", function () {
     var idComponente = $(this).data('id');
     $("#modalLog #idComponente").val( idComponente );
     carregarLog();
});
function carregarLog(){
    var idComponente     = $("#idComponente").val();
    $.ajax({
        url:'<?=base_url()?>index.php/modallog/carregarLog',
        method: 'post',
        data: {
                idComponente : idComponente
                },
        dataType: 'json',
        success: function(response){
            $("#bodyLog").html(response.lista);
        }
    });
}
</script>
