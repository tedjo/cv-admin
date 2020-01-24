$(document).ready(function () {

	$('.check_access').on('click', function () {
		const menuId = $(this).data('menu');
		const roleId = $(this).data('role');

		$.ajax({
			url: "changeaccess/",
			type: 'post',
			data: {
				menuId: menuId,
				roleId: roleId
			},
			success: function () {
				document.location.href = "roleaccess";
			}
		});
	});

	$('.add_menumanager').on('click', function () {
		var add_menu = $('#add_menu').val();

		$.ajax({
			url: "addManager/",
			type: 'POST',
			data: {
				add_menu: add_menu
			},
			success: function () {
				document.location.href = "management";
			}
		});
	});

	$('.show_menumanager').on('click', function () {
		var menu_id = $(this).data('show_id');

		$.ajax({
			url: "showManager/",
			type: 'POST',
			data: {
				menu_id: menu_id
			},
			dataType: 'json',
			success: function (data) {
				$('#menu_id').val(menu_id);
				$('#show_menu').val(data.show_menu);
				$('#editModal').modal('show');
			}
		});
	});

	$('.edit_menumanager').on('click', function () {
		var menu_id = $('#menu_id').val();
		var menu_menu = $('#show_menu').val();

		$.ajax({
			url: "editManager/",
			type: 'POST',
			data: {
				menu_id: menu_id,
				menu_menu: menu_menu
			},
			success: function () {
				document.location.href = "management";
			}
		});
	});

	$('.delete_menumanager').on('click', function () {
		var show_id = $(this).data('show_id');
		var id_manager = $(this).data('id_manager');
		var menu_url = $(this).data('menu_url');
		var menu_id = $('#delete_menu_id').val();

		$.ajax({
			url: menu_url,
			type: 'POST',
			data: {
				menu_id: menu_id
			},
			success: function () {
				if (id_manager == 1) {
					document.location.href = "management";
				} else {
					$('#delete_menu_id').val(show_id);
					$('#deletModalManagement').modal('show');
				}
			}
		});
	});

	$('.check_access_menu').on('click', function () {
		const templateId = $(this).data('template');
		const activeId = $(this).data('active');

		$.ajax({
			url: "changeAccSubMenu/",
			type: 'post',
			data: {
				templateId: templateId,
				activeId: activeId
			},
			success: function () {
				document.location.href = "submenu";
			}
		});
	});

	$('.delete_menu').on('click', function () {
		var deleteId = $(this).data("delete_menu_");
		var templateId = $(this).data("templateid");

		var deleteurl = $(this).data("deleteurl");
		var showId = $('#showid').val();
		var showTemplateId = $('#showTemplateid').val();

		$.ajax({
			url: deleteurl,
			method: "POST",
			data: {
				deleteId: showId,
				templateId: showTemplateId
			},
			success: function () {
				if (templateId > 0) {
					$('#showid').val(deleteId);
					$('#showTemplateid').val(templateId);
					$('#deletModal').modal('show');
				} else {
					document.location.href = "submenu";
				}

			}
		});
	});

	$('.edit_menu').on('click', function () {
		var show_id = $('#show_id').val();
		var show_title = $('#show_title').val();
		var show_icon = $('#show_icon').val();

		$.ajax({
			url: "update_menu/",
			method: "POST",
			data: {
				show_id: show_id,
				show_title: show_title,
				show_icon: show_icon
			},
			success: function () {
				document.location.href = "submenu";
			}
		});
	});

	$('.show_edit_menu').on('click', function () {
		var editDataId = $(this).data("show_menu_");
		$.ajax({
			url: "edit_menu/",
			method: "POST",
			data: {
				editDataId: editDataId
			},
			dataType: 'json',
			success: function (data) {
				$('#show_id').val(data.template_id);
				$('#show_title').val(data.title_menu);
				$('#show_menu').val(data.menu_menu);
				$('#show_icon').val(data.icon_menu);
				$('#show_checked_icon').prop('checked', true);
				$('#show_icon').prop('disabled', false);
				$('#edit_data_Modal').modal('show');
			}
		});
	});

	$('.add_sub_menu').on('click', function () {
		var add_title = $('#add_title').val();
		var add_menu = $('#add_menu').val();
		var add_icon = $('#add_icon').val();
		var add_is_active = $('#add_is_active').val();

		$.ajax({
			url: "add_menu_/",
			method: "POST",
			data: {
				add_title: add_title,
				add_menu: add_menu,
				add_icon: add_icon,
				add_is_active: add_is_active
			},
			success: function () {
				document.location.href = "submenu";
			}
		});
	});

	$('.show_icon_costume').on('click', function () {
		$.ajax({
			success: function () {
				$('#add_icon').val('');
				$('#add_icon').prop('disabled', false);
			}
		});
	});

	$('.show_icon_edit').on('click', function () {
		var editDataId = $('#show_id').val();
		$.ajax({
			url: "edit_menu/",
			method: "POST",
			data: {
				editDataId: editDataId
			},
			dataType: 'json',
			success: function (data) {
				if (editDataId > 0) {
					$('#show_icon').val(data.icon_menu);
					$('#show_icon').prop('disabled', false);
				}
			}
		});
	});

	$('.show_icon_default').on('click', function () {
		var edit_iconId = $('#show_id').val();
		$.ajax({
			url: "edit_icon/",
			method: "POST",
			data: {
				edit_iconId: edit_iconId
			},
			dataType: 'json',
			success: function (data) {
				if (edit_iconId > 0) {
					$('#add_icon').val(data.title_menu);
					$('#add_icon').prop('disabled', true);
				}
				$('#show_icon').val(data.title_menu);
				$('#show_icon').prop('disabled', true);
			}
		});
	});

	$('.select_add_colom').on('click', function () {
		$.ajax({
			url: "menu/insertSubtitle/",
			method: "POST",
			success: function () {
				document.location.href = "menu";
			}
		});
	});

	$('.select_del_colom').on('click', function () {
		var id_title = $(this).data("delete_query_id");

		$.ajax({
			url: "menu/deleteSubtitle/",
			method: "POST",
			data: {
				id_title: id_title
			},
			success: function () {
				document.location.href = "menu";
			}
		});
	})

	$('.save_sub_title').on('click', function () {
		var id_title = $(this).data("save_query_id");
		var sub_title = $('#title_effect' + id_title).val();
		$.ajax({
			url: "menu/updateSubtitle/",
			method: "POST",
			data: {
				id_title: id_title,
				sub_title: sub_title,
			},
			success: function () {
				document.location.href = "menu";
			}
		});
	})

	$('.check_sosmet_save').on('click', function () {
		var id_sosmet = $(this).data("id_sosmet");
		var acun_sosmet = $('#acun_sosmet' + id_sosmet).val();
		var check_sosmet = $(this).data("chek_sosmet");

		$.ajax({
			url: "menu/checkSosmet/",
			method: "POST",
			data: {
				id_sosmet: id_sosmet,
				acun_sosmet: acun_sosmet,
				check_sosmet: check_sosmet
			},
			success: function () {
				document.location.href = "menu";
			}
		});
	})

	$('.custom-file-input').on('change', function () {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass("selected").html(fileName);
	});
});
