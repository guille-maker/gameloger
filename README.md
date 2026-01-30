# 🎮 Gameloger: Mi Perfil Gamer – Aplicación Laravel

*Gameloger* es una aplicación web para registrar, visualizar y gestionar tu colección de videojuegos. Esta versión representa una reconstrucción completa del layout, la navegación y el estilo, incorporando una estética moderna inspirada en interfaces manga/anime.

Desarrollada en *Laravel*, permite a los usuarios gestionar tanto su perfil personal como su biblioteca de videojuegos, combinando un backend robusto con una interfaz oscura, estilizada y altamente visual, diseñada para ofrecer una experiencia fluida, atractiva y totalmente personalizada.

---

## ✨ Características principales

### 👤 Perfil del usuario
- Foto de perfil (avatar).
- Biografía o descripción personal.
- Nombre y datos básicos.
- Edición de perfil mediante formulario o modal.
- Visualización del perfil en una tarjeta estilizada.

### 🎮 Gestión de juegos del usuario
- Añadir juegos a tu colección personal.
- Ver tus juegos en tarjetas personalizadas con estilo oscuro/rojo.
- Guardar información detallada:
  - Progreso (%)
  - Comentarios
  - Dificultad
  - Horas jugadas
  - Estado (completado/no completado)
  - Fechas de inicio y fin
  - URL de captura de pantalla
- Editar juegos mediante un **modal dinámico**.
- Eliminar juegos de la colección.
- Orden automático por fecha de creación.

### 🖼️ Interfaz moderna
- Estética “gaming” con colores personalizados:
  - `midnight`, `phantom`, `spirit`, `velvet`
- Sombras rojas dinámicas.
- Tarjetas con bordes brillantes.
- Diseño responsive con Tailwind CSS.
- Componentes Blade reutilizables (`<x-game-card>`).

### 🧭 Navegación clara
- Menú superior con enlaces a:
  - Inicio
  - Perfil
  - Mis juegos
  - Listado general de juegos
  - Posts
- Dropdown de usuario con:
  - Mi perfil
  - Configuración
  - Cambiar tema
  - Cerrar sesión

### 🧩 Arquitectura limpia
- Controladores separados:
  - `UserGameController` → gestión de juegos del usuario.
  - `ProfileController` → datos personales.
- Rutas con nombres distintos pero que pueden apuntar al mismo contenido.
- Vistas organizadas en componentes y parciales.

---

## 🛠️ Tecnologías utilizadas

### Backend
- **Laravel** (Framework principal)
- **PHP 8.2**
- **Eloquent ORM**
- **Laravel Breeze / Jetstream** para autenticación

### Frontend
- **Blade Templates**
- **Tailwind CSS**
- **Alpine.js** para interactividad ligera
- **Componentes Blade personalizados**

### Base de datos
- **MySQL / MariaDB**

### Control de versiones
- **Git + GitHub**

---
## Capturas del proyecto

### 1. Inicio con actividad reciente
![Inicio con actividad reciente](assets/images/1.png)  
**Descripción:** Pantalla principal mostrando actividad reciente, juegos populares y secciones de juegos comenzados (comenzados, en pausa).  
**Alt:** Inicio con actividad reciente y secciones de progreso

---

### 2. Añadir juego — búsqueda
![Añadir juego — búsqueda](assets/images/2.png)  
**Descripción:** Interfaz de búsqueda al añadir un juego; ejemplo buscando "Zelda".  
**Alt:** Búsqueda de juego mostrando resultados para Zelda

---

### 3. Juego con datos rellenados
![Juego con datos rellenados](assets/images/3.png)  
**Descripción:** Vista de un juego con todos los datos completados: título, plataforma, progreso y metadatos.  
**Alt:** Página de juego con información y progreso rellenados

---

### 4. Mi lista de juegos
![Mi lista de juegos](assets/images/4.png)  
**Descripción:** Lista personal de juegos con progreso, dificultad y botón para añadir nuevos juegos.  
**Alt:** Lista de juegos con progreso, dificultad y botón añadir

---

### 5. Editar juego
![Editar juego](assets/images/5.png)  
**Descripción:** Formulario de edición de un juego ya añadido para actualizar progreso y notas.  
**Alt:** Formulario para editar los datos de un juego existente

---

### 6. Biblioteca con filtros
![Biblioteca con filtros](assets/images/6.png)  
**Descripción:** Biblioteca de juegos con selectores por género y consola para filtrar resultados.  
**Alt:** Biblioteca de juegos con filtros por género y consola

---

### 7. Ejemplo de filtrado 1
![Ejemplo de filtrado 1](assets/images/7.png)  
**Descripción:** Ejemplo mostrando resultados tras aplicar filtros por género o plataforma.  
**Alt:** Resultados filtrados por género/plataforma (ejemplo 1)

---

### 8. Ejemplo de filtrado 2
![Ejemplo de filtrado 2](assets/images/8.png)  
**Descripción:** Otro ejemplo de filtrado que muestra cómo se combinan varios criterios.  
**Alt:** Resultados filtrados por varios criterios (ejemplo 2)

---

### 9. Panel superior con cambio de contraste
![Panel superior contraste](assets/images/9.png)  
**Descripción:** Panel superior con controles de accesibilidad, incluido cambio de contraste.  
**Alt:** Barra superior con control de contraste y accesibilidad

---

### 10. Perfil personal
![Perfil personal](assets/images/10.png)  
**Descripción:** Página de perfil del usuario con estadísticas, avatar y ajustes personales.  
**Alt:** Página de perfil del usuario con estadísticas y ajustes

---

### 11. Inicio con cambio de color
![Inicio con cambio de color](assets/images/11.png)  
**Descripción:** Ejemplo de la página de inicio con esquema de color alternativo aplicado.  
**Alt:** Página de inicio con esquema de color alternativo

---

### Logotipo
![Logotipo](assets/images/logotipo.png)  
**Descripción:** Logotipo personal del proyecto, usado en cabecera y favicon.  
**Alt:** Logotipo del proyecto

---
## 🚀 Instalación

```bash
git clone https://github.com/TU_USUARIO/mi-perfil-gamer.git
cd mi-perfil-gamer
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 📌 Roadmap (ideas futuras)

- 🎖️ Sistema de logros por juego  
- 📊 Estadísticas del usuario  
- 🏆 Ranking de juegos completados  
- 🔗 Integración con APIs externas (IGDB, RAWG)  
- 🖼️ Subida real de capturas de pantalla  
- 👥 Perfiles públicos y amigos  

---

## 📄 Licencia
Este proyecto es de uso personal. Puedes adaptarlo o expandirlo libremente.

