<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADC File Drive</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: #f3f6f1;
            color: #111827;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 270px;
            height: 100vh;
            background: #111827;
            padding: 28px 22px;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .sidebar img {
            width: 170px;
            display: block;
            margin: 0 auto 35px;
        }

        .sidebar h3 {
            color: #8aff5c;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .sidebar .desc {
            color: #cbd5e1;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .user-box {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 15px;
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .user-box p {
            font-size: 13px;
            color: #d1d5db;
            margin-bottom: 10px;
        }

        .user-box p:last-child {
            margin-bottom: 0;
        }

        .logout {
            margin-top: auto;
            width: 100%;
            border: none;
            color: #111827;
            background: #8aff5c;
            padding: 13px;
            border-radius: 14px;
            text-align: center;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout:hover {
            background: #73e84a;
            transform: translateY(-1px);
        }

        .main {
            margin-left: 270px;
            padding: 28px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 26px 30px;
            border-radius: 22px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .topbar h1 {
            font-size: 28px;
            color: #111827;
            margin-bottom: 6px;
        }

        .topbar p {
            color: #6b7280;
            font-size: 14px;
        }

        .topbar-badge {
            background: #ecffe5;
            color: #166534;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
            white-space: nowrap;
        }

        .upload-card {
            background: white;
            border-radius: 22px;
            padding: 26px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            margin-bottom: 26px;
        }

        .drop-area {
            min-height: 165px;
            border: 2px dashed #8aff5c;
            background: #f0ffe9;
            padding: 28px;
            text-align: center;
            border-radius: 20px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }

        .drop-area:hover {
            background: #e7ffdb;
            border-color: #73e84a;
        }

        .drop-area.dragover {
            background: #dfffce;
            border-color: #5fdc38;
            transform: scale(1.01);
        }

        .upload-icon {
            width: 58px;
            height: 58px;
            background: #8aff5c;
            color: #111827;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 26px;
            font-weight: 900;
        }

        .drop-area h2 {
            color: #111827;
            margin-bottom: 6px;
            font-size: 21px;
        }

        .drop-area p {
            color: #6b7280;
            font-size: 14px;
        }

        input[type="file"] {
            display: none;
        }

        .upload-btn {
            background: #8aff5c;
            border: none;
            padding: 15px 20px;
            border-radius: 16px;
            font-weight: 800;
            cursor: pointer;
            color: #111827;
            transition: 0.2s;
        }

        .upload-btn:hover {
            background: #73e84a;
            transform: translateY(-1px);
        }

        .inside-upload-btn {
            margin-top: 18px;
            width: auto;
            min-width: 180px;
        }

        .notification {
            background: #dcfce7;
            color: #166534;
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title h2 {
            font-size: 21px;
        }

        .section-title span {
            color: #6b7280;
            font-size: 13px;
        }

        .files-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 18px;
        }

        .file-card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            border: 1px solid #eef2f7;
        }

        .file-icon {
            width: 56px;
            height: 56px;
            background: #8aff5c;
            color: #111827;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 14px;
        }

        .file-card h4 {
            font-size: 15px;
            margin-bottom: 8px;
            word-break: break-word;
            color: #111827;
        }

        .file-card p {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .file-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .file-actions a,
        .file-actions button {
            width: 100%;
            text-align: center;
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
        }

        .preview {
            background: #ecffe5;
            color: #166534;
        }

        .download {
            background: #111827;
            color: white;
        }

        .delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 38px;
            text-align: center;
            color: #6b7280;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17,24,39,0.65);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            width: 100%;
            max-width: 390px;
            background: white;
            border-radius: 22px;
            padding: 26px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
            text-align: center;
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            background: #ecffe5;
            color: #166534;
            border-radius: 18px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 900;
        }

        .modal-box h3 {
            font-size: 22px;
            margin-bottom: 8px;
            color: #111827;
        }

        .modal-box p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-actions button,
        .modal-actions a {
            flex: 1;
            padding: 12px;
            border-radius: 13px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: 800;
            font-size: 14px;
        }

        .cancel-btn {
            background: #e5e7eb;
            color: #111827;
        }

        .confirm-btn {
            background: #8aff5c;
            color: #111827;
        }

        .preview-box {
            width: 95%;
            max-width: 1000px;
            height: 90vh;
            background: white;
            border-radius: 22px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .preview-header {
            padding: 18px 22px;
            background: #111827;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-header h3 {
            font-size: 16px;
            word-break: break-word;
            padding-right: 15px;
        }

        .preview-header button {
            background: #8aff5c;
            border: none;
            min-width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .preview-content {
            flex: 1;
            background: #f3f6f1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            padding: 20px;
        }

        .preview-content img,
        .preview-content iframe,
        .preview-content video {
            max-width: 100%;
            max-height: 100%;
            border-radius: 12px;
        }

        .preview-content iframe {
            width: 100%;
            height: 100%;
        }

        .preview-content audio {
            width: 80%;
        }

        @media(max-width: 900px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout {
                margin-top: 10px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .file-actions {
                grid-template-columns: 1fr;
            }
        }

        .preview-header-actions {
            display: flex;
            gap: 10px;
        }

        .fullscreen-btn,
        .close-preview-btn {
            background: #8aff5c;
            border: none;
            min-width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <img src="/images/ADC Final Logo PNG.png" alt="ADC Logo">

    <h3>ADC File Drive</h3>
    <p class="desc">Encode, upload, and manage company files in one secure dashboard.</p>

    <div class="user-box">
        <p><strong>User:</strong> {{ session('name') }}</p>
        <p><strong>Role:</strong> {{ session('role') }}</p>
    </div>

    <button type="button" class="logout" onclick="openLogoutModal()">Logout</button>
</div>

<div class="main">

    <div class="topbar">
        <div>
            <h1>File Upload Dashboard</h1>
            <p>Upload, preview, download, and manage encoded company files.</p>
        </div>

        <div class="topbar-badge">
            ADC General Merchandise Inc.
        </div>
    </div>

    @if(session('success'))
        <div class="notification">
            {{ session('success') }}
        </div>
    @endif

    <div class="upload-card">
        <form action="/upload" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf

            <label for="fileInput" class="drop-area" id="dropArea">
                <div>
                    <div class="upload-icon">↑</div>

                    <h2>Upload File</h2>

                    <p id="fileName">
                        Click here or drag your files here
                    </p>

                    <button
                        type="button"
                        class="upload-btn inside-upload-btn"
                        onclick="openUploadModal()"
                    >
                        Upload File
                    </button>
                </div>
            </label>

            <input type="file" name="file" id="fileInput" required>
        </form>
    </div>

    <div class="section-title">
        <h2>Uploaded Files</h2>
        <span>{{ count($files) }} file(s)</span>
    </div>

    <div class="files-grid">
        @forelse($files as $file)
            @php
                $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                $fileUrl = asset('storage/' . $file->file_path);
            @endphp

            <div class="file-card">
                <div class="file-icon">📄</div>

                <h4>{{ $file->original_name }}</h4>
                <p>{{ number_format($file->file_size / 1024, 2) }} KB</p>

                <div class="file-actions">
                    <button
                        type="button"
                        class="preview"
                        onclick="openPreviewModal(
                            '{{ $fileUrl }}',
                            '{{ $extension }}',
                            '{{ addslashes($file->original_name) }}'
                        )"
                    >
                        Preview
                    </button>

                    <a href="/download/{{ $file->id }}" class="download">
                        Download
                    </a>

                    <form action="/delete-file/{{ $file->id }}" method="POST" class="deleteForm">
                        @csrf
                        <button type="button" class="delete" onclick="openDeleteModal(this)">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                No files uploaded yet.
            </div>
        @endforelse
    </div>

</div>

<div class="modal-overlay" id="uploadModal">
    <div class="modal-box">
        <div class="modal-icon">↑</div>
        <h3>Upload Confirmation</h3>
        <p>Are you sure you want to upload this file?</p>

        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeUploadModal()">Cancel</button>
            <button type="button" class="confirm-btn" onclick="confirmUpload()">Upload</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">!</div>
        <h3>Delete Confirmation</h3>
        <p>Are you sure you want to delete this file?</p>

        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="confirm-btn" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <div class="modal-icon">!</div>
        <h3>Logout Confirmation</h3>
        <p>Are you sure you want to logout from ADC File Drive?</p>

        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeLogoutModal()">Cancel</button>
            <a href="/logout" class="confirm-btn">Logout</a>
        </div>
    </div>
</div>

<div class="modal-overlay" id="previewModal">
    <div class="preview-box">
        <div class="preview-header">

    <h3 id="previewTitle">File Preview</h3>

    <div class="preview-header-actions">

        <button
            type="button"
            class="fullscreen-btn"
            onclick="toggleFullscreen()"
        >
            ⛶
        </button>

        <button
            type="button"
            class="close-preview-btn"
            onclick="closePreviewModal()"
        >
            ✕
        </button>

    </div>

</div>

        <div class="preview-content" id="previewContent"></div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    const dropArea = document.getElementById('dropArea');
    const uploadForm = document.getElementById('uploadForm');

    let selectedDeleteForm = null;

    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
        }
    });

    dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('dragover');
        fileName.textContent = 'Release file to upload';
    });

    dropArea.addEventListener('dragleave', function () {
        dropArea.classList.remove('dragover');

        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        } else {
            fileName.textContent = 'Click here or drag your files here';
        }
    });

    dropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        dropArea.classList.remove('dragover');

        const files = e.dataTransfer.files;

        if (files.length > 0) {
            fileInput.files = files;
            fileName.textContent = files[0].name;
        }
    });

    function openUploadModal() {
        if (fileInput.files.length === 0) {
            alert('Please choose a file first.');
            return;
        }

        document.getElementById('uploadModal').classList.add('active');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.remove('active');
    }

    function confirmUpload() {
        uploadForm.submit();
    }

    function openDeleteModal(button) {
        selectedDeleteForm = button.closest('form');
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        selectedDeleteForm = null;
        document.getElementById('deleteModal').classList.remove('active');
    }

    function confirmDelete() {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    }

    function openLogoutModal() {
        document.getElementById('logoutModal').classList.add('active');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.remove('active');
    }

    function openPreviewModal(fileUrl, extension, fileNameText) {
        const modal = document.getElementById('previewModal');
        const content = document.getElementById('previewContent');
        const title = document.getElementById('previewTitle');

        title.textContent = fileNameText;

        let html = '';

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
            html = `<img src="${fileUrl}" alt="${fileNameText}">`;
        } else if (extension === 'pdf') {
            html = `
                <iframe
                    src="${fileUrl}"
                    width="100%"
                    height="100%"
                    style="border:none;"
                ></iframe>
            `;
        } else if (['mp4', 'webm', 'ogg'].includes(extension)) {
            html = `
                <video controls>
                    <source src="${fileUrl}">
                    Your browser does not support video preview.
                </video>
            `;
        } else if (['mp3', 'wav', 'mpeg'].includes(extension)) {
            html = `
                <audio controls>
                    <source src="${fileUrl}">
                    Your browser does not support audio preview.
                </audio>
            `;
        } else if (['txt', 'csv', 'log'].includes(extension)) {
            html = `
                <iframe
                    src="${fileUrl}"
                    width="100%"
                    height="100%"
                    style="border:none;background:white;"
                ></iframe>
            `;
        } else {
            html = `
                <div style="text-align:center;">
                    <h3 style="margin-bottom:8px;color:#111827;">Preview not available</h3>
                    <p style="color:#6b7280;margin-bottom:18px;">
                        This file type cannot be previewed in the browser.
                    </p>
                    <a
                        href="${fileUrl}"
                        target="_blank"
                        style="
                            display:inline-block;
                            background:#8aff5c;
                            color:#111827;
                            padding:12px 18px;
                            border-radius:12px;
                            font-weight:800;
                            text-decoration:none;
                        "
                    >
                        Open File
                    </a>
                </div>
            `;
        }

        content.innerHTML = html;
        modal.classList.add('active');
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.remove('active');
        document.getElementById('previewContent').innerHTML = '';
    }

    function toggleFullscreen() {

    const previewBox = document.querySelector('.preview-box');

    if (!document.fullscreenElement) {

        previewBox.requestFullscreen();

    } else {

        document.exitFullscreen();

    }

}
</script>

</body>
</html>