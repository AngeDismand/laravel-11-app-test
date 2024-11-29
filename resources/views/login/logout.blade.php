<script>
    async function logout() {
        try {
            const response = await fetch('/api/logout', {
                method: 'POST',
                headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Accept': 'application/json'
            },
            });
            const data = await response.json();
            console.log(data);
            console.log(response)

            if (response.ok) {
                alert('Logout successful!');
                window.location.href = '/login';
                
            } else {
                alert(data.message || 'Logout failed');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    logout();
</script>