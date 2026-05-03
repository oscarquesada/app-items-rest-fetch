# 🧾 App Items - CRUD con PHP, Eloquent y Fetch

Aplicación web CRUD desarrollada en PHP que permite gestionar items (crear, listar, editar y eliminar) utilizando una arquitectura moderna basada en API REST y consumo con Fetch desde el frontend.

---

## 🚀 Tecnologías utilizadas

- PHP
- Eloquent ORM
- MySQL
- JavaScript (Fetch API)
- Bootstrap 5
- HTML5 + CSS3

---

## 🧠 Arquitectura

La aplicación está separada en capas:


Frontend (JS + HTML)
↓
Fetch API
↓
API REST (PHP)
↓
Modelo (Eloquent ORM)
↓
Base de datos (MySQL)


---

## ⚙️ Funcionalidades

- ✔ Listado de items  
- ✔ Búsqueda por nombre  
- ✔ Crear nuevos items  
- ✔ Editar items existentes  
- ✔ Eliminar items  
- ✔ Validación de datos  
- ✔ Manejo de errores HTTP  
- ✔ Tema dinámico (modo claro / oscuro)  

---

## 🔗 Endpoints principales


GET /api/items → obtener todos los items
GET /api/items?q=texto → buscar items
GET /api/items?id=1 → obtener un item
POST /api/items → crear item
PUT /api/items?id=1 → actualizar item
DELETE /api/items?id=1 → eliminar item


---

## 💻 Frontend

El frontend utiliza JavaScript con Fetch para comunicarse con la API sin recargar la página.

Ejemplo:

```js
fetch('/api/items?q=mouse')
🎨 UI
Interfaz construida con Bootstrap 5
Estilos personalizados con variables CSS
Soporte para modo claro y modo oscuro
📁 Estructura del proyecto
public/
│
├── index.php
├── css/
│   └── styles.css
├── js/
│   ├── items.js
│   ├── create-item.js
│   ├── edit-item.js
│   └── theme.js

src/
├── models/
├── routes/
└── views/

📌 Conceptos aplicados
API REST
Fetch API
Separación de responsabilidades
Arquitectura tipo MVC (simplificada)
Manejo de estados y validaciones
Uso de ORM (Eloquent)