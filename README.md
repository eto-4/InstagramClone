# Instagram Clone — Laravel 12

Un aplicatiu web similar a Instagram desenvolupat amb Laravel 12, Breeze, Tailwind CSS i Alpine.js.

---

## Requisits previs

- PHP 8.2+
- Composer
- Node.js (LTS)
- MySQL (XAMPP o equivalent)

---

## Instal·lació

### 1. Clonar el repositori

```bash
git clone <url-del-repositori>
cd instagram-clone
```

### 2. Instal·lar dependències PHP

```bash
composer install
```

### 3. Instal·lar dependències Node

```bash
npm install
```

### 4. Configurar l'arxiu `.env`

Copia l'arxiu d'exemple i configura la base de dades:

```bash
cp .env.example .env
```

Edita el `.env` amb les teves dades de MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=instagram_clone
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar la clau de l'aplicació

```bash
php artisan key:generate
```

### 6. Crear la base de dades

Obre phpMyAdmin o el teu client MySQL i crea una base de dades anomenada `instagram_clone` amb cotejament `utf8mb4_unicode_ci`.

### 7. Executar les migracions i els seeders

```bash
php artisan migrate --seed
```

Això crearà totes les taules i les poblarà amb dades de prova (10 usuaris, imatges, comentaris i likes).

### 8. Crear l'enllaç simbòlic de l'storage

```bash
php artisan storage:link
```

---

## Execució en local

Necessites dues terminals obertes simultàniament:

**Terminal 1 — Servidor Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Compilació d'assets (Tailwind + Vite):**
```bash
npm run dev
```

Accedeix a l'aplicació a: [http://localhost:8000](http://localhost:8000)

---

## Estructura de la base de dades

| Taula | Descripció |
|-------|------------|
| `users` | Usuaris registrats (name, email, password, phone_number, avatar) |
| `images` | Publicacions dels usuaris (image_path, description, user_id) |
| `comments` | Comentaris de les publicacions (body, user_id, image_id) |
| `likes` | Likes de les publicacions (user_id, image_id) |

---

## Funcionalitats

### Autenticació
- Registre amb nom, email, contrasenya i telèfon (opcional)
- Login i logout
- Edició del perfil (nom, email, telèfon, avatar)

### Publicacions
- Llistat paginat de totes les publicacions a la pàgina d'inici
- Modal estil Instagram en fer clic a una publicació
- Vista standalone accessible per URL directa (`/images/{id}`)
- Crear, editar i eliminar publicacions pròpies
- Previsualització de la imatge abans de pujar-la

### Comentaris
- Afegir comentaris a una publicació
- Editar i eliminar comentaris propis
- Els comentaris s'actualitzen sense recarregar la pàgina

### Likes
- Fer i desfer like a una publicació
- El cor es torna vermell de forma reactiva amb JavaScript
- Animació en fer like
- Sincronització entre el modal i la targeta del home

### Perfil públic
- Vista del perfil de cada usuari amb grid de publicacions
- Avatar o inicials com a placeholder
- Nom d'usuari estil `@Nom_Usuari`

---

## Tecnologies utilitzades

| Tecnologia | Ús |
|------------|-----|
| Laravel 12 | Framework PHP backend |
| Laravel Breeze | Autenticació (login, registre, perfil) |
| Tailwind CSS | Estils i disseny responsive |
| Alpine.js | Interactivitat del navbar i modals |
| Vite | Compilació d'assets |
| MySQL | Base de dades relacional |
| JavaScript (Fetch API) | Likes i comentaris reactius sense recarregar |

---

## Credencials de prova

Tots els usuaris generats pel seeder tenen la mateixa contrasenya:

```
password
```

Pots consultar els emails dels usuaris a la taula `users` de la base de dades o des de phpMyAdmin.

---

## Comandos útils

```bash
# Refer les migracions i tornar a sembrar les dades
php artisan migrate:fresh --seed

# Crear un nou usuari administrador manualment
php artisan tinker

# Comprovar totes les rutes registrades
php artisan route:list
```

---

## Estructura de carpetes destacada

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ImageController.php
│   │   ├── CommentController.php
│   │   ├── LikeController.php
│   │   ├── UserController.php
│   │   └── ProfileController.php
│   └── Requests/
│       └── ProfileUpdateRequest.php
└── Models/
    ├── User.php
    ├── Image.php
    ├── Comment.php
    └── Like.php

database/
├── factories/
├── migrations/
└── seeders/

resources/views/
├── layouts/
├── partials/
│   └── post-modal.blade.php
├── posts/
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── users/
│   └── show.blade.php
├── comments/
│   └── edit.blade.php
└── home.blade.php
```