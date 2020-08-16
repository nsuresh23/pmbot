
define("tinymce/pasteplugin/SmartPaste", [
	"tinymce/util/Tools"
], function (Tools) {
	var isAbsoluteUrl = function (url) {
		return /^https?:\/\/[\w\?\-\/+=.&%]+$/i.test(url);
	};

	var isImageUrl = function (url) {
		return isAbsoluteUrl(url) && /.(gif|jpe?g|jpng)$/.test(url);
	};

	var createImage = function (editor, url, pasteHtml) {
		editor.undoManager.extra(function () {
			pasteHtml(url);
		}, function () {
			editor.insertContent('<img src="' + url + '">');
		});

		return true;
	};

	var createLink = function (editor, url, pasteHtml) {
		editor.undoManager.extra(function () {
			pasteHtml(url);
		}, function () {
			editor.execCommand('mceInsertLink', false, url);
		});

		return true;
	};

	var linkSelection = function (editor, html, pasteHtml) {
		return editor.selection.isCollapsed() === false && isAbsoluteUrl(html) ? createLink(editor, html, pasteHtml) : false;
	};

	var insertImage = function (editor, html, pasteHtml) {
		return isImageUrl(html) ? createImage(editor, html, pasteHtml) : false;
	};

	var insertContent = function (editor, html) {
		var pasteHtml = function (html) {
			editor.insertContent(html, {
				merge: editor.settings.paste_merge_formats !== false,
				paste: true
			});

			return true;
		};

		var fallback = function (editor, html) {
			pasteHtml(html);
		};

		Tools.each([
			linkSelection,
			insertImage,
			fallback
		], function (action) {
			return action(editor, html, pasteHtml) !== true;
		});
	};

	return {
		isImageUrl: isImageUrl,
		isAbsoluteUrl: isAbsoluteUrl,
		insertContent: insertContent
	};
});
