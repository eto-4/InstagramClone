<!-- Modal -->
<div id="post-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-70">
    <div class="bg-white w-full max-w-4xl mx-4 rounded-lg overflow-hidden flex" style="max-height: 90vh;">

        <!-- Imatge esquerra -->
        <div class="w-1/2 bg-black flex items-center justify-center">
            <img id="modal-image" src="" alt="" class="w-full h-full object-contain" style="max-height: 90vh;" />
        </div>

        <!-- Contingut dreta -->
        <div class="w-1/2 flex flex-col" style="max-height: 90vh;">

            <!-- Capçalera usuari -->
            <div id="modal-user" class="flex items-center gap-3 px-4 py-3 border-b border-gray-100">
                <!-- Spinner mentre carrega -->
                <div id="modal-user-spinner" class="w-full flex justify-center py-2">
                    <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </div>
                <div id="modal-user-content" class="hidden flex items-center gap-3 w-full">
                    <a id="modal-user-link" href="#">
                        <div id="modal-avatar-container"></div>
                    </a>
                    <div>
                        <a id="modal-user-link2" href="#" class="font-semibold text-sm text-gray-800 hover:underline"></a>
                        <div id="modal-date" class="text-xs text-gray-400"></div>
                    </div>
                    <button id="modal-close" class="ml-auto text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Descripció -->
            <div id="modal-description" class="px-4 py-3 text-sm text-gray-700 border-b border-gray-100 hidden"></div>

            <!-- Comentaris amb scroll -->
            <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3" id="modal-comments">
                <!-- Spinner comentaris -->
                <div id="modal-comments-spinner" class="flex justify-center py-4">
                    <svg class="animate-spin h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </div>
                <div id="modal-comments-list" class="hidden space-y-3"></div>
            </div>

            <!-- Likes -->
            <div class="px-4 py-2 border-t border-gray-100 flex items-center gap-3 text-sm text-gray-600">
                <button id="modal-like-btn" class="flex items-center gap-1 focus:outline-none">
                    <svg id="modal-like-icon" xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 transition"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <span id="modal-like-count">0</span> likes
                </button>
                <span id="modal-comment-count" class="text-xs text-gray-400"></span>
            </div>

            <!-- Input comentari -->
            @auth
            <div class="px-4 py-3 border-t border-gray-100">
                <form id="modal-comment-form" method="POST" class="flex items-center gap-2">
                    @csrf
                    <input
                        type="text"
                        name="body"
                        id="modal-comment-input"
                        placeholder="{{ __('Afegeix un comentari...') }}"
                        class="flex-1 text-sm border-0 border-b border-gray-300 focus:ring-0 focus:border-indigo-500 bg-transparent px-0"
                        required
                    />
                    <button type="submit" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 focus:outline-none">
                        {{ __('Enviar') }}
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    <!-- Mini modal d'edició de comentari -->
    <div id="edit-comment-modal" class="fixed inset-0 z-60 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 p-6">

            <!-- Títol -->
            <h3 class="text-sm font-semibold text-gray-800 mb-4">{{ __('Editar comentari') }}</h3>

            <!-- Blockquote amb el text original -->
            <blockquote class="border-l-4 border-gray-300 pl-3 mb-4 text-sm text-gray-500 italic" id="edit-comment-original"></blockquote>

            <!-- Input nou text -->
            <input
                type="text"
                id="edit-comment-input"
                class="w-full text-sm border-0 border-b border-gray-300 focus:ring-0 focus:border-indigo-500 bg-transparent px-0 mb-6"
                required
            />

            <!-- Botons -->
            <div class="flex justify-between mt-4">
                <button id="edit-comment-cancel" class="text-sm text-gray-500 hover:text-gray-700">
                    {{ __('Cancel·lar') }}
                </button>
                <button id="edit-comment-submit" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                    {{ __('Corregir') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ─── Estat del modal ───────────────────────────────────────────────
    let currentImageId = null;

    // ─── Obrir modal ──────────────────────────────────────────────────
    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn.dataset.id));
    });

    function openModal(imageId) {
        currentImageId = imageId;
        const modal = document.getElementById('post-modal');

        // Mostrem el modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Reset estat
        resetModal();

        // Fetch de les dades
        fetch(`/images/${imageId}/data`)
            .then(res => res.json())
            .then(data => renderModal(data));
    }

    function resetModal() {
        // Spinner usuari
        document.getElementById('modal-user-spinner').classList.remove('hidden');
        document.getElementById('modal-user-content').classList.add('hidden');
        document.getElementById('modal-description').classList.add('hidden');
        // Spinner comentaris
        document.getElementById('modal-comments-spinner').classList.remove('hidden');
        document.getElementById('modal-comments-list').classList.add('hidden');
        document.getElementById('modal-comments-list').innerHTML = '';
        // Imatge buida
        document.getElementById('modal-image').src = '';
    }

    function renderModal(data) {
        // Imatge
        document.getElementById('modal-image').src = data.image_url;

        // Avatar
        const avatarContainer = document.getElementById('modal-avatar-container');
        if (data.user.avatar) {
            avatarContainer.innerHTML = `<img src="${data.user.avatar}" alt="${data.user.name}" class="w-9 h-9 rounded-full object-cover" />`;
        } else {
            avatarContainer.innerHTML = `<div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">${data.user.initials}</div>`;
        }

        // Usuari
        document.getElementById('modal-user-link').href  = data.user.url;
        document.getElementById('modal-user-link2').href = data.user.url;
        document.getElementById('modal-user-link2').textContent = data.user.name;
        document.getElementById('modal-date').textContent = data.created_at;

        // Amaguem spinner usuari
        document.getElementById('modal-user-spinner').classList.add('hidden');
        document.getElementById('modal-user-content').classList.remove('hidden');

        // Descripció
        if (data.description) {
            const desc = document.getElementById('modal-description');
            desc.innerHTML = `<span class="font-semibold">${data.user.name}</span> ${data.description}`;
            desc.classList.remove('hidden');
        }

        // Likes
        updateLikeIcon(
            document.getElementById('modal-like-icon'),
            data.liked,
            data.like_count,
            document.getElementById('modal-like-count')
        );

        // Comentaris
        document.getElementById('modal-comment-count').textContent = `${data.comment_count} comentaris`;
        renderComments(data.comments);

        // URL del formulari de comentari
        const form = document.getElementById('modal-comment-form');
        if (form) form.action = `/images/${data.id}/comments`;
    }

    function renderComments(comments) {
        const list = document.getElementById('modal-comments-list');
        list.innerHTML = '';

        if (comments.length === 0) {
            list.innerHTML = `<p class="text-sm text-gray-400">Encara no hi ha comentaris.</p>`;
        } else {
            comments.forEach(comment => {
                const avatarHtml = comment.user.avatar
                    ? `<img src="${comment.user.avatar}" alt="${comment.user.name}" class="w-7 h-7 rounded-full object-cover flex-shrink-0" />`
                    : `<div class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">${comment.user.initials}</div>`;

                const actionsHtml = comment.is_owner
                    ? `<div class="flex gap-2 mt-1">
                           <button onclick="openEditComment(${comment.id}, '${comment.update_url}', '${comment.body.replace(/'/g, "\\'")}')" class="text-xs text-gray-400 hover:text-gray-600">Editar</button>
                           <form method="POST" action="${comment.delete_url}" class="inline delete-comment-form">
                               <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]')?.content ?? ''}">
                               <input type="hidden" name="_method" value="DELETE">
                               <button type="submit" class="text-xs text-red-400 hover:text-red-600">Eliminar</button>
                           </form>
                       </div>`
                    : '';

                list.innerHTML += `
                    <div class="flex gap-2">
                        <a href="${comment.user.url}">${avatarHtml}</a>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">${comment.user.name}</span>
                            <span class="text-sm text-gray-700"> ${comment.body}</span>
                            <div class="text-xs text-gray-400 mt-0.5">${comment.created_at}</div>
                            ${actionsHtml}
                        </div>
                    </div>`;
            });
        }

        // Amaguem spinner comentaris
        document.getElementById('modal-comments-spinner').classList.add('hidden');
        list.classList.remove('hidden');
    }

    // ─── Tancar modal ─────────────────────────────────────────────────
    document.getElementById('modal-close').addEventListener('click', closeModal);
    document.getElementById('post-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function closeModal() {
        const modal = document.getElementById('post-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentImageId = null;
    }

    // ─── Like des de la targeta ───────────────────────────────────────
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                // Actualitzem icona
                updateLikeIcon(
                    btn.querySelector('.like-icon'),
                    data.liked,
                    data.like_count,
                    btn.querySelector('.like-count')
                );
                btn.dataset.liked = data.liked ? 'true' : 'false';
            });
        });
    });

    // ─── Like des del modal ───────────────────────────────────────────
    document.getElementById('modal-like-btn').addEventListener('click', () => {
        if (!currentImageId) return;

        fetch(`/images/${currentImageId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                'Content-Type': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            // Actualitzem modal
            updateLikeIcon(
                document.getElementById('modal-like-icon'),
                data.liked,
                data.like_count,
                document.getElementById('modal-like-count')
            );

            // Sincronitzem la targeta
            const cardBtn = document.querySelector(`.like-btn[data-id="${currentImageId.toString()}"]`);
            if (cardBtn) {
                const cardIcon = cardBtn.querySelector('.like-icon');
                const cardCount = cardBtn.querySelector('.like-count');
                if (cardIcon && cardCount) {
                    updateLikeIcon(cardIcon, data.liked, data.like_count, cardCount);
                    cardBtn.dataset.liked = data.liked ? 'true' : 'false';
                }
            }
        });
    });

    // ─── Actualitza la icona i anima el like ─────────────────────────
    function updateLikeIcon(icon, liked, count, countEl) {
        if (liked) {
            animateLike(icon)
        }
        icon.setAttribute('fill', liked ? 'red' : 'none');
        icon.setAttribute('stroke', liked ? 'red' : 'currentColor');
        if (countEl) countEl.textContent = count;
    }
    // ─── Animació del like ────────────────────────────────────────────
    function animateLike(icon) {
        icon.style.transition = 'transform 0.15s ease';
        icon.style.transform = 'scale(2)';
        setTimeout(() => {
            icon.style.transform = 'scale(1)';
        }, 150);
    }

    // Publicar comentaris amb fetch
    // ─── Enviar comentari sense recarregar ────────────────────────────
    document.getElementById('modal-comment-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const input = document.getElementById('modal-comment-input');
        const body = input.value.trim();
        if (!body) return;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ body })
        })
        .then(res => {
            if (res.ok) {
                // Buidem l'input
                input.value = '';
                // Recarreguem els comentaris del modal
                fetch(`/images/${currentImageId}/data`)
                    .then(r => r.json())
                    .then(data => {
                        renderComments(data.comments);
                        document.getElementById('modal-comment-count').textContent = `${data.comment_count} comentaris`;
                        
                        // Actualitzem també el comptador de la targeta
                        const cardCommentCount = document.querySelector(`.comment-count[data-id="${currentImageId.toString()}"]`);
                        if (cardCommentCount) cardCommentCount.textContent = data.comment_count;
                    });
            }
        });
    });

    // ─── Eliminar comentari sense recarregar ─────────────────────────
    document.getElementById('modal-comments-list').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        if (!form.matches('.delete-comment-form')) return;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(res => {
            if (res.ok) {
                fetch(`/images/${currentImageId}/data`)
                    .then(r => r.json())
                    .then(data => {
                        renderComments(data.comments);
                        document.getElementById('modal-comment-count').textContent = `${data.comment_count} comentaris`;

                        // Actualitzem també el comptador de la targeta
                        const cardCommentCount = document.querySelector(`.comment-count[data-id="${currentImageId.toString()}"]`);
                        if (cardCommentCount) cardCommentCount.textContent = data.comment_count;
                    });
            }
        });
    });

    // ─── Mini modal d'edició de comentari ────────────────────────────
    let currentCommentId = null;
    let currentCommentUrl = null;

    function openEditComment(commentId, commentUrl, commentBody) {
        currentCommentId = commentId;
        currentCommentUrl = commentUrl;

        document.getElementById('edit-comment-original').textContent = commentBody;
        document.getElementById('edit-comment-input').value = commentBody;

        const modal = document.getElementById('edit-comment-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('edit-comment-input').focus();
    }

    function closeEditComment() {
        const modal = document.getElementById('edit-comment-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentCommentId = null;
        currentCommentUrl = null;
    }

    document.getElementById('edit-comment-cancel').addEventListener('click', closeEditComment);

    document.getElementById('edit-comment-submit').addEventListener('click', () => {
        const body = document.getElementById('edit-comment-input').value.trim();
        if (!body) return;

        fetch(currentCommentUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ _method: 'PATCH', body })
        })
        .then(res => {
            if (res.ok) {
                closeEditComment();
                // Recarreguem els comentaris del modal
                fetch(`/images/${currentImageId}/data`)
                    .then(r => r.json())
                    .then(data => {
                        renderComments(data.comments);
                        document.getElementById('modal-comment-count').textContent = `${data.comment_count} comentaris`;
                    });
            }
        });
    });
</script>