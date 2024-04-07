
<div class="container">
    <div class="row">
        <div class="span12">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default-cliente">Create task</button>

<table class="table" id="fechas">
<thead>
    <tr>
        <th>Date</th>
        <th>Title</th>
        <th>Completed</th>
        <th>Deadline</th>
        <th>Text</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>


<?php foreach ($tasks as $tasks_item): ?>
    <tr id="task_<?php echo $tasks_item['id']; ?>">
        <td><?php echo date("d/m/Y", strtotime($tasks_item['created_at'])) ; ?></td>
        <td><?php echo $tasks_item['title']; ?></td>
        <td><?php if ($tasks_item['completed'] == 0){ echo "No";}else{echo "Yes";} ?></td>
        <td><?php echo date("d/m/Y", strtotime($tasks_item['deadline'])); ?></td>
        <td><?php echo $tasks_item['text']; ?></td>
        <td>
        <?php if ($tasks_item['completed'] == 0){ ?>
            <a href="#complete" dbid="<?php echo $tasks_item['id']; ?>" data-toggle="modal" class="btn btn-success btn-accion"  title="Complete task">Complete task</a>
        <?php } ?>
            <a href="#eliminar" dbid="<?php echo $tasks_item['id']; ?>" data-toggle="modal" class="btn btn-danger btn-mini btn-accion" title="Delete"><i class="icon icon-ban-circle"></i>Delete</a>
        </td>
    </tr>

<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
<input type="hidden" value="" id="task_id" />
<div id="eliminar" class="modal fade"  >
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Task</h4>
            </div>
            <div class="modal-body">
            <p>¿Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_eliminar">Yes</button>
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">No</button>
            </div>
        </div>   
</div>
</div>

<div id="complete" class="modal fade"  >
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Complete Task</h4>
            </div>
            <div class="modal-body">
            <p>¿Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_complete">Yes</button>
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">No</button>
            </div>
        </div>   
</div>
</div>

<div class="modal fade" id="modal-default-cliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Task</h4>
            </div>
            <div class="modal-body">

         

            <div class="form-group">
               <label for="title">Title:</label>
               <input type="text" class="form-control" name="title" id="title">
            </div>   
            <div class="form-group">
                <label for="nombrecompleto">Deadline:</label>
                <input type="date" class="form-control" name="deadline" id="deadline" required="required">
            </div>

            

            <div class="form-group">
               <label for="direccion">Text:</label>
               <textarea name="text" class="form-control" id="text" required="required"></textarea>
            </div>

                <div class="form-group">
                    <input type="button" id="btn_save" class="btn btn-success" value="Save">
                </div>
                      

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>            
    </div>        
</div>
<script type="text/javascript" charset="utf-8"> 
$(document).on("click", ".btn-accion", function() {
    $('#task_id').val($(this).attr('dbid'));
});
// eliminar
$('#btn_eliminar').click(function() {    
    var id = $('#task_id').val();
    console.log("val: "+ id)

    $.ajax({
        dataType: 'json',
        type: 'DELETE',
        url: 'delete/' + id,
        success: function(responseText) {
            $('#task_id').val('');
            $('#eliminar').modal('hide');
            location.reload();
        }
    });
});

// complete
$('#btn_complete').click(function() {    
    var id = $('#task_id').val();
    console.log("val: "+ id)

    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: 'complete/' + id,
        success: function(responseText) {
            $('#task_id').val('');
            $('#eliminar').modal('hide');
            location.reload();
        }
    });
});

//guardar
$('#btn_save').click(function() {    
    var title = $('#title').val();
    var deadline = $('#deadline').val();
    var text = $('#text').val();
    if (title === "" || deadline === "" || text === ""){
        alert("Please insert all the inputs");
        return false;
    }
    console.log("title: "+title+" deadline: "+ deadline + " text: "+text);

    $.post('create', { title: title, deadline : deadline, text : text}, 
    function(returnedData){
         console.log(returnedData);
         location.reload();
    }).fail(function(){
        console.log("error");
    });
});
</script>