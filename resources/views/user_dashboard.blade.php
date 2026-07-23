<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADC File Preview</title>
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

        .desc {
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

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
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

        .preview {
            width: 100%;
            background: #ecffe5;
            color: #166534;
            border: none;
            padding: 11px;
            border-radius: 12px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 800;
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

        .preview-header-actions {
            display: flex;
            gap: 10px;
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

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
            }
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
    </style>
</head>

<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">

        <div class="modal-icon">!</div>

        <h3>Logout Confirmation</h3>

        <p>
            Are you sure you want to logout from ADC File Preview?
        </p>

        <div class="modal-actions">

            <button
                type="button"
                class="cancel-btn"
                onclick="closeLogoutModal()"
            >
                Cancel
            </button>

            <a href="/logout" class="confirm-btn">
                Logout
            </a>

        </div>

    </div>
</div>

<body>

<div class="sidebar">
    <img src="/images/ADC Final Logo PNG.png" alt="ADC Logo">

    <h3>ADC File Preview</h3>
    <p class="desc">View and preview uploaded company files.</p>

    <div class="user-box">
        <p><strong>User:</strong> {{ session('name') }}</p>
        <p><strong>Role:</strong> {{ session('role') }}</p>
    </div>

    <button type="button" class="logout" onclick="openLogoutModal()">
        Logout
    </button>
</div>

<div class="main">

    <div class="topbar">
        <div>
            <h1>User File Preview</h1>
            <p>You can preview uploaded files only. Upload, download, and delete are disabled.</p>
        </div>

        <div class="topbar-badge">
            ADC General Merchandise Inc.
        </div>
    </div>

    <div class="section-title">
        <h2>Available Files</h2>
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

                <button
                    type="button"
                    class="preview"
                    onclick="openPreviewModal(
                        '{{ $fileUrl }}',
                        '{{ $extension }}',
                        '{{ addslashes($file->original_name) }}'
                    )"
                >
                    Preview File
                </button>
            </div>
        @empty
            <div class="empty-state">
                No uploaded files available.
            </div>
        @endforelse
    </div>

</div>

<div class="modal-overlay" id="previewModal">
    <div class="preview-box">
        <div class="preview-header">
            <h3 id="previewTitle">File Preview</h3>

            <div class="preview-header-actions">
                <button type="button" onclick="toggleFullscreen()">⛶</button>
                <button type="button" onclick="closePreviewModal()">✕</button>
            </div>
        </div>

        <div class="preview-content" id="previewContent"></div>
    </div>
</div>

<script>
    function openPreviewModal(fileUrl, extension, fileNameText) {
        const modal = document.getElementById('previewModal');
        const content = document.getElementById('previewContent');
        const title = document.getElementById('previewTitle');

        title.textContent = fileNameText;

        let html = '';

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
            html = `<img src="${fileUrl}" alt="${fileNameText}">`;
        } else if (extension === 'pdf') {
            html = `<iframe src="${fileUrl}" style="border:none;"></iframe>`;
        } else if (['mp4', 'webm', 'ogg'].includes(extension)) {
            html = `<video controls><source src="${fileUrl}"></video>`;
        } else if (['mp3', 'wav', 'mpeg'].includes(extension)) {
            html = `<audio controls><source src="${fileUrl}"></audio>`;
        } else if (['txt', 'csv', 'log'].includes(extension)) {
            html = `<iframe src="${fileUrl}" style="border:none;background:white;"></iframe>`;
        } else {
            html = `
                <div style="text-align:center;">
                    <h3 style="margin-bottom:8px;color:#111827;">Preview not available</h3>
                    <p style="color:#6b7280;">This file type cannot be previewed in the browser.</p>
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

    function openLogoutModal() {

    document.getElementById('logoutModal')
        .classList.add('active');

}

function closeLogoutModal() {

    document.getElementById('logoutModal')
        .classList.remove('active');

}
</script>

</body>
</html>