<!-- contact Modal -->
<div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id = "modal-contact-title">添加联系人</h4>
            </div>
            <div class="modal-body">
                <form id="form-contact" action="javascript:void(0)">
                    <label for="form-contact-name" class="sr-only">姓名</label>
                    <input type="text" id="form-contact-name" class="form-group form-control" placeholder="姓名" required>

                    <div id="form-contact-telephones" >
                        <div class="input-group form-group"><label for="telephone" class="sr-only">电话号</label>
                            <input type="tel" class="form-group form-control" placeholder="电话号码" required>
                            <a class="input-group-addon telephone-input-del" href="javascript:void(0)"><span class="glyphicon glyphicon-trash"></span></a>
                        </div>
                        <a class="telephone-add input-group form-group" href="javascript:void(0)"><span class="input-group-addon glyphicon glyphicon-plus"></span></a>
                    </div>
                    <label for="form-contact-remark" class="sr-only">备注</label>
                    <input type="text" id="form-contact-remark" class="form-group form-control" placeholder="备注">
                    <label for="form-contact-group" class="sr-only">分组</label>
                    <select id="form-contact-group" class="form-group form-control" required>
                        <option value="0">默认分组</option>
                    </select>
                    <div>
                        <input type="hidden" id="form-contact-id" class="form-group form-control" />
                        <input type="hidden" id="form-contact-submit-type" class="form-group form-control" />
                        <button id="form-contact-submit" type="submit" class="btn btn-primary btn-primary">保存</button>
                        <span id="form-contact-msg" class="text-danger"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- msg modal -->
<div class="modal fade" id="modal-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 id="modal-msg-title" class="modal-title">通知</h4>
			</div>
			<div class="modal-body">
				<h4 id="modal-msg-content" class="text-msg text-center">Hello World!</h4>
			</div>
		</div>
	</div>
</div>
