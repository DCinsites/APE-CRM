<style>
   .select2-container {
   width: 100% !important;
   padding: 0;
   }
   .select2-multiple{
   width: 100% !important;
   }
</style>
<div  id="taskModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalCenterTitle">@lang('form.task')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="taskModalForm" method="post" action="">
               {{ csrf_field()  }}
               <input type="hidden" name="id" value="">
               <input type="hidden" name="project_id" value="{{ $rec->id }}">
          
               
               <div class="form-row">
                  <div class="form-group col-md-4">
                     <label>@lang('form.priority')</label>
                     <?php
                        echo form_dropdown('priority_id', $data['priority_id_list'] , "", "class='form-control  selectPickerWithoutSearch '");
                        ?>
                  </div>
                  <div class="form-group col-md-4">
                     <label>@lang('form.milestone')</label>
                     <?php
                        echo form_dropdown('milestone_id', $data['milestones_id_list'] , "", "class='form-control  selectPickerWithoutSearch '");
                        ?>
                  </div>
                  <div class="form-group col-md-4">
                     <label>@lang('form.assigned_to')</label>
                     <?php
                        echo form_dropdown('assigned_to', $data['assigned_to_list'] ,"", "class='form-control  selectpicker'");
                        ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="title">@lang('form.title') <span class="required">*</span> </label>
                  <input type="text" class="form-control form-control-sm" name="title" value="">
                  <div class="invalid-feedback d-block"></div>
               </div>
               <div class="form-group">
                  <label>@lang('form.description') </label>
                  <textarea class="form-control" name="description" id="descriptionTextArea" rows="6"></textarea>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="title">@lang('form.start_date')</label>
                     <input type="text" class="form-control form-control-sm initially_empty_datepicker" name="start_date" value="">
                     <div class="invalid-feedback d-block"></div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>@lang('form.due_date') </label>
                     <input type="text" class="form-control form-control-sm initially_empty_datepicker" name="due_date" value="">
                     <div class="invalid-feedback"></div>
                  </div>
               </div>
              <?php 
                  echo upload_button('taskModalForm');
                  ?>
            </form>
         </div>
         <div class="modal-footer">
            <div class="form-check">
               <input class="form-check-input" name="create_new_checkbox" id="create_new_checkbox" type="checkbox" value="1">
               <label class="form-check-label" for="defaultCheck1">
               @lang('form.submit_and_create_new')
               </label>
            </div>
            <button type="button" class="btn btn-primary" id="submitForm">@lang('form.submit')</button>
         </div>
      </div>
   </div>
</div>