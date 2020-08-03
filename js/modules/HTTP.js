class HTTP {
    // Make an HTTP DELETE Request
    async delete(url) {
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-type': 'application/json',
                'X-WP-Nonce': kho_university_data.nonce
            },
            credentials: 'same-origin'
        })
        return await response.json();
    }
}

export default HTTP;