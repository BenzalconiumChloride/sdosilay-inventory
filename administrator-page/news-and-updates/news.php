<style>
  #uploadArea:hover {
            border-color: #0d6efd !important;
            background-color: #e7f1ff !important;
        }
        
        .image-preview-item {
            position: relative;
            display: inline-block;
            margin: 10px;
        }
        
        .image-preview-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .remove-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            line-height: 1;
            padding: 0;
        }
        
        .remove-image-btn:hover {
            background: #c82333;
        }
        
        #imagePreviewContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
</style>
<div class="card radius-10">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <h5 class="mb-0">News and Updates</h5>
            </div>
            <div class="dropdown options ms-auto">
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addNews">
                    <i class='bx bx-plus'></i> Add
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>News Header</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="newsTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNews" tabindex="-1" aria-labelledby="addNewsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-top border-0 border-4 border-white">
                    <div class="card-body p-5">
                        <form id="customerForm">
                            <div class="col-12">
                                <!-- Upload Area - Now supports multiple -->
                                <div id="uploadArea" class="border rounded p-4 text-center" style="border: 2px dashed #dee2e6; background-color: #f8f9fa; cursor: pointer; transition: all 0.3s;">
                                    <input type="file" class="form-control d-none" id="inputFile" name="images[]" accept="image/*" multiple onchange="handleMultipleImages(event)">
                                    <label for="inputFile" style="cursor: pointer; margin: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cloud-upload text-secondary mb-3" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                            <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
                                        </svg>
                                        <div class="fw-bold text-dark">Click to upload images</div>
                                        <small class="text-muted">or drag and drop (multiple files)</small>
                                        <div class="mt-2"><small class="text-muted">PNG, JPG, GIF up to 10MB each</small></div>
                                    </label>
                                </div>

                                <!-- Multiple Image Preview Container -->
                                <div id="imagePreviewContainer"></div>
                            </div>
                            
                            <div class="col-md-12 mt-2">
                                <label for="header" class="form-label">Header</label>
                                <input type="text" class="form-control" id="nHeader" name="nHeader">
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <label class="form-label">Type</label>
                                    <div class="border rounded p-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="newsType" id="type_news" value="news" required>
                                            <label class="form-check-label" for="type_news">News</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="newsType" id="type_event" value="event">
                                            <label class="form-check-label" for="type_event">Event</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="newsType" id="type_memo" value="memo">
                                            <label class="form-check-label" for="type_memo">Memo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <label for="eventDate" class="form-label">Event Date</label>
                                    <input type="date" class="form-control" id="eventDate" name="eventDate">
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-2">
                                <label for="nContent" class="form-label">Content</label>
                                <textarea class="form-control" id="nContent" name="nContent" placeholder="Content..." rows="3"></textarea>
                            </div>
                            
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-light col-12 mx-auto">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/* ==============================
   GLOBAL STATE
============================== */
let isEditing = false;
let currentEditId = null;
let selectedFiles = []; // Store selected files

/* ==============================
   HANDLE MULTIPLE IMAGES
============================== */
function handleMultipleImages(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('imagePreviewContainer');
    
    files.forEach((file, index) => {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert(`${file.name} is not an image file`);
            return;
        }
        
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert(`${file.name} is too large. Maximum size is 10MB`);
            return;
        }
        
        // Add to selected files array
        selectedFiles.push(file);
        
        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'image-preview-item';
            previewItem.dataset.index = selectedFiles.length - 1;
            
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-image-btn" onclick="removeImageByIndex(${selectedFiles.length - 1})">
                    ×
                </button>
            `;
            
            container.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
    
    // Clear the input so the same file can be selected again if needed
    event.target.value = '';
}

/* ==============================
   REMOVE IMAGE BY INDEX
============================== */
function removeImageByIndex(index) {
    // Remove from array
    selectedFiles.splice(index, 1);
    
    // Rebuild preview container
    rebuildImagePreviews();
}

/* ==============================
   REBUILD IMAGE PREVIEWS
============================== */
function rebuildImagePreviews() {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'image-preview-item';
            previewItem.dataset.index = index;
            
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-image-btn" onclick="removeImageByIndex(${index})">
                    ×
                </button>
            `;
            
            container.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
}

/* ==============================
   EVENT DATE TOGGLE
============================== */
function toggleEventDate(type) {
    const eventDate = document.getElementById('eventDate');
    if (!eventDate) return;
    
    eventDate.disabled = false;
    eventDate.required = (type === 'event');
}

/* ==============================
   RADIO LISTENER
============================== */
document.querySelectorAll('input[name="newsType"]').forEach(radio => {
    radio.addEventListener('change', () => {
        toggleEventDate(radio.value);
    });
});

/* ==============================
   FORM SUBMIT
============================== */
document.getElementById('customerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    
    // Remove the empty file input from FormData
    formData.delete('images[]');
    
    // Add selected files to FormData
    selectedFiles.forEach((file, index) => {
        formData.append('images[]', file);
    });

    if (isEditing) {
        formData.append('tId', currentEditId);
    }

    const url = isEditing ? 'api/edit-news.php' : 'api/add.php';

    try {
        const res = await fetch(url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });

        const json = await res.json();

        if (!json.success) {
            alert(json.message || 'Failed');
            return;
        }

        alert(json.message);

        // Reset form and images
        form.reset();
        selectedFiles = [];
        document.getElementById('imagePreviewContainer').innerHTML = '';

        isEditing = false;
        currentEditId = null;

        document.querySelector('#addNews button[type="submit"]').textContent = 'Save changes';

        bootstrap.Modal.getInstance(document.getElementById('addNews')).hide();
        loadNews();
    } catch (error) {
        console.error('Submit error:', error);
        alert('An error occurred while submitting the form');
    }
});

/* ==============================
   ESCAPE HTML
============================== */
function escapeHtml(text) {
    return text ? text.replace(/[&<>"']/g, m => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m])) : '';
}

/* ==============================
   LOAD NEWS
============================== */
async function loadNews() {
    const res = await fetch('api/fetch-news.php', { credentials:'same-origin' });
    const json = await res.json();

    if (!json.success) return;

    const tbody = document.getElementById('newsTableBody');
    tbody.innerHTML = '';

    json.data.forEach((row, i) => {
        let badge = `<span class="badge bg-success">News</span>`;
        if (row.isEvent == 1) badge = `<span class="badge bg-info">Event</span>`;
        if (row.isAnnouncement == 1) badge = `<span class="badge bg-warning">Memo</span>`;

        tbody.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>
                ${row.thumbnail ? `<img src="../assets/uploads/news/${row.thumbnail}" style="width:60px;height:60px;object-fit:cover">` : ''}
            </td>
            <td>${escapeHtml(row.nHeader)}</td>
            <td>${escapeHtml(row.nContent.substring(0,60))}...</td>
            <td>${badge}</td>
            <td>${row.eventDate || row.dateAdded}</td>
            <td>
                <a href="#" class="edit-news" data-id="${row.tId}"><i class="bx bx-edit"></i></a>
                <a href="#" class="delete-news ms-3 text-danger" data-id="${row.tId}">
                    <i class="bx bx-trash"></i>
                </a>
            </td>
        </tr>`;
    });
}

/* ==============================
   TABLE ACTIONS
============================== */
document.getElementById('newsTableBody').addEventListener('click', async (e) => {
    e.preventDefault();

    if (e.target.closest('.edit-news')) {
        openEditModal(e.target.closest('.edit-news').dataset.id);
    }

    if (e.target.closest('.delete-news')) {
        deleteNews(e.target.closest('.delete-news').dataset.id);
    }
});

/* ==============================
   OPEN EDIT MODAL
============================== */
async function openEditModal(id) {
    try {
        const res = await fetch(`api/fetch-news.php?id=${id}`, { credentials: 'same-origin' });
        const json = await res.json();

        if (!json.success || !json.data) {
            alert('Failed to load news');
            return;
        }

        const n = json.data;

        document.getElementById('nHeader').value = n.nHeader || '';
        document.getElementById('nContent').value = n.nContent || '';

        const sub = document.getElementById('nsubHeader');
        if (sub) sub.value = n.nSubHeader || '';

        document.querySelectorAll('input[name="newsType"]').forEach(r => {
            r.checked = r.value === n.newsType;
        });

        toggleEventDate(n.newsType);
        if (n.newsType === 'event' && n.eventDate) {
            document.getElementById('eventDate').value = n.eventDate.substring(0, 10);
        }

        // Clear previous images
        selectedFiles = [];
        document.getElementById('imagePreviewContainer').innerHTML = '';

        // TODO: Load existing images if your API returns them
        // If n.images is an array of image URLs, you can display them here

        isEditing = true;
        currentEditId = id;
        document.querySelector('#addNews button[type="submit"]').textContent = 'Update News';

        new bootstrap.Modal(document.getElementById('addNews')).show();

    } catch (err) {
        console.error(err);
        alert('Edit error');
    }
}

/* ==============================
   DELETE
============================== */
async function deleteNews(id) {
    if (!confirm('Delete this news?')) return;

    const fd = new FormData();
    fd.append('tId', id);

    const res = await fetch('api/delete-news.php', {
        method:'POST',
        body:fd,
        credentials:'same-origin'
    });

    const json = await res.json();
    if (json.success) loadNews();
    else alert(json.message);
}

/* ==============================
   RESET ON MODAL CLOSE
============================== */
document.getElementById('addNews').addEventListener('hidden.bs.modal', () => {
    document.getElementById('customerForm').reset();
    selectedFiles = [];
    document.getElementById('imagePreviewContainer').innerHTML = '';
    isEditing = false;
    currentEditId = null;
});

/* ==============================
   INIT
============================== */
document.addEventListener('DOMContentLoaded', loadNews);
</script>