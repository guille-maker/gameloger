<x-app-layout>
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Tus juegos</h1>
    <div id="games" class="space-y-4"></div>
  </div>

  <script>
    const token = localStorage.getItem('token');

    if (!token) {
      window.location.href = '/login';
    }

    fetch('/api/user-games', {
      headers: {
        'Authorization': 'Bearer ' + token
      }
    })
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('games');
      if (data.length === 0) {
        container.innerHTML = '<p>No tienes juegos registrados.</p>';
        return;
      }

      container.innerHTML = data.map(game => `
        <div class="p-4 bg-white shadow rounded">
          <h2 class="text-lg font-semibold">${game.title}</h2>
          <p><strong>Progreso:</strong> ${game.progress || 'Sin progreso'}</p>
          <p><strong>Comentario:</strong> ${game.comment || 'Sin comentarios'}</p>
          ${game.screenshot_url ? `<img src="${game.screenshot_url}" class="mt-2 w-32">` : ''}
        </div>
      `).join('');
    })
    .catch(err => {
      console.error('Error al cargar juegos:', err);
      document.getElementById('games').innerHTML = '<p>Error al cargar tus juegos.</p>';
    });
  </script>
</x-app-layout>
