
### Authentication Flow:
1. **Initial Authentication Request (`index.php`):**
   - Redirects the user to the Microsoft OAuth authorization URL.
   - The user is asked to grant permission to read their user data (`user.read` scope).

```php
$oauthUrl = "https://login.microsoftonline.com/$tenantID/oauth2/v2.0/authorize?" .
    "client_id=$clientID&" .
    "response_type=code&" .
    "redirect_uri=$redirectURI&" .
    "scope=user.read&" .
    "response_mode=query";

header("Location: $oauthUrl");
exit;
```

2. **Callback Handling (`redirect.php`):**
   - Handles the callback from Microsoft after the user grants permission.
   - Retrieves the authorization code from the query parameters.
   - Exchanges the authorization code for an access token.

```php
$tokenUrl = "https://login.microsoftonline.com/$tenantID/oauth2/v2.0/token";
$tokenData = array(
    'client_id' => $clientID,
    'scope' => 'user.read',
    'code' => $code,
    'redirect_uri' => $redirectURI,
    'grant_type' => 'authorization_code',
    'client_secret' => $clientSecret
);

// Sends a POST request to exchange the code for an access token
// Stores the access token in the session if successful
```

3. **Access Token Storage and Redirection (`redirect.php`):**
   - If the access token is successfully retrieved, it is stored in the PHP session.
   - The user is then redirected to the `welcome.php` page.

```php
if (isset($json->access_token)) {
    $_SESSION['access_token'] = $json->access_token;
    header("Location: welcome.php");
    exit;
} else {
    // Handle error
    exit('Error retrieving access token.');
}
```

4. **Access Token Validation (`welcome.php`):**
   - Checks if the user is authenticated by verifying the presence of the access token in the session.

```php
session_start();

if (!isset($_SESSION['access_token'])) {
    header("Location: index.php");
    exit;
}
```

### Photo Gallery:
- Displays a simple photo gallery with navigation buttons (`Previous` and `Next`).
- Images are stored in an array, and JavaScript is used to dynamically change the displayed image.

### Notes:
- Ensure that you replace placeholders like `$tenantID`, `$clientID`, `$clientSecret` with your actual Microsoft application credentials.
- Make sure to handle errors more gracefully in a production environment.
- It's crucial to secure the storage and transmission of access tokens and other sensitive information.


# Entra ID php App

## Authentication and App Registration

The Entra ID php App uses Microsoft OAuth for user authentication. This document outlines the authentication flow and provides instructions for app registration in the Microsoft Azure portal.

### Authentication Flow

1. **User Authentication Request:**
   - Users are redirected to the Microsoft OAuth authorization URL.
   - App requests permission for `user.read` scope.

2. **Microsoft OAuth Authorization:**
   - Users log in and grant permissions.
   - Microsoft redirects users back with an authorization code.

3. **Token Exchange (Callback Handling):**
   - `redirect.php` handles the callback, exchanging the code for an access token via a POST request.

4. **Access Token Storage:**
   - Successful exchange results in storing the access token in the PHP session.

5. **Access Token Validation:**
   - `welcome.php` checks the session for the access token to verify user authentication.
   - If not authenticated, users are redirected to the authentication page.

### App Registration in Microsoft Azure Portal

Follow these steps to register your app in the Azure portal:

1. **Sign in to the Azure portal:**
   - [Azure portal](https://portal.azure.com/).
   - Sign in with your Microsoft account.

2. **Create a new Azure AD application:**
   - Navigate to **Azure Active Directory > App registrations > New registration**.
   - Provide app details and set the redirect URI.

3. **Note down the application details:**
   - Record **Application (client) ID** and **Directory (tenant) ID**.
   - Under **Certificates & Secrets**, generate and note a client secret.

4. **Configure API permissions:**
   - In the app overview, go to **API permissions**.
   - Add required permissions like `User.Read` for user data access.

5. **Update app credentials in code:**
   - Replace placeholders (`$tenantID`, `$clientID`, `$clientSecret`) with obtained values.

### Usage

Clone the repository and set up your Microsoft app registration credentials in the PHP code. Ensure proper permissions for seamless user authentication.

```bash
git clone https://github.com/yourusername/entra-id-photo-gallery.git
cd entra-id-photo-gallery
```

### License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### Acknowledgments

- Microsoft OAuth for secure user authentication.
- PHP for server-side scripting.
- JavaScript for dynamic gallery functionality.

### Conclusion

Follow these steps to set up the Entra ID Photo Gallery App with Microsoft OAuth for secure and efficient user authentication. Enjoy showcasing your photo collection!
