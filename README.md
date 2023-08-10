# project-skeleton
Un squelette de nouveau projet node

## A quoi ça sert ?

Ceci est un environement de développement pré-configuré et prêt à être déployé rapidement sur `netlify` ou `vercel`.

Voici ses fonctionalités:
- Remplacement du [Live Server](https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer)
- Remplacement de [Live Sass Compiler](https://marketplace.visualstudio.com/items?itemName=glenn2223.live-sass)
- permettre l'utilisation de librairies [npm](https://www.npmjs.com/) pour accélérer votre développement
- avoir une structure claire pour commencer un nouveau projet


## Comment l'installer ?

Sur github:
- Utiliser le bouton vert `Use this template`
- `Create a new repository`

Sur votre terminal (utilisez la repo que vous venez de créer)
```bash
git clone https://github.com/<username>/<repo>.git
cd <repo>
```

Installer les dépendances (sass + postcss + rollup + express):
```bash
npm install
```

## Comment l'utiliser ?

- Les sources `php` sont dans le répertoire `src`
- Les sources `Javascript` sont dans le répertoire `lib`
- Les sources `sass` sont dans le répertoire `scss`
- Les fichiers html et autres resources (images...) sont dans le répertoire `public`

Pour commencer à développer:
```bash
npm run dev
```
Cela va ouvrir un serveur http avec autorefresh sur http://localhost:8000/
et compiler les sources à mesure qu'elles sont sauvegardées.

## Quelles sont les autres commandes ?

Vous pouvez ouvrir un serveur de développement `php` sur http://localhost:8001:
```bash
npm run php:start
```
- todo: utiliser [express](https://www.npmjs.com/package/php) live reload pour le faire 


Vous pouvez créer une version de production de vos `js` et `css`:<br>
(minifiés et tout...)
```bash
npm run build
```
Pour utiliser seulement le serveur `http`:<br>
(`dev` ne doit pas être lancé, sinon ça va pas marcher)
```bash
npm run start
```
Pour utiliser seulement le `watch` mode (autocompilation css/js):
```bash
npm run dev:rollup
```
## A quoi servent les fichiers `.spa` ?

Les fichiers `.spa` sont des fichiers de configuration `apache` et <a href="https://docs.netlify.com/routing/redirects/" target="_blank">netlify</a> pour rediriger toutes les requêtes sur `index.html` rendant votre application `"Single Page Application"` avec utilisation de <a href="https://developer.mozilla.org/en-US/docs/Web/API/History/pushState" target="_blank">history</a> ou sans.<br>
Vous devez juste avoir ou créer un routeur pour le gerer (eg: <a href="https://visionmedia.github.io/page.js/" target="_blank">Page.js</a>)

Pour utiliser le site en `SPA` vous devez :
- enlever l'extension `.spa` des fichiers:
  - `.htaccess`
  - `_redirects`


- décommenter ces lignes dans `server.js` (l'autoreload va se charger du reste): 
```js
app.get('*', (req, res) =>
{
    res.sendFile(path.resolve(process.cwd(), "public", "index.html"));
});

```
- modifier votre ficher `index.html` et ajouter cette balise dans `<head>`:<br>
(cela va éviter les erreur de chargement dans des adresses telles que `/user/55665`)
```html
<base href="/">
```

## Utilisation avec VS Code

Ce projet contient des réglages pour formatter vos fichers [php](https://www.php-fig.org/psr/psr-12/) `css` `scss` en uniformisant les formats de codage, ces réglages utilisent ces extensions pour fonctionner:
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) (détecte et affiche les erreurs pendant le codage)
- [php cs fixer](https://marketplace.visualstudio.com/items?itemName=junstyle.php-cs-fixer) (formatte les fichiers `php` à la sauvegarde)
- [SCSS Formatter](https://marketplace.visualstudio.com/items?itemName=sibiraj-s.vscode-scss-formatter)
- [Code Runner](https://marketplace.visualstudio.com/items?itemName=formulahendry.code-runner) (permet de tester son code en dehors du navigateur)

## Pour publier sur netlify ?

Pour publier votre site sur `netlify` (à partir de `github`) vous avez juste à mettre ces paramètres (c'est tout):
- Base directory: `public`
- Publish directory: `public/`



