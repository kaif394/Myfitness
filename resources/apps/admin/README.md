# Laravel SvelteKit Admin App

Admin application for LaraGym built with SvelteKit

## Developing

Once you've created a project and installed dependencies with `npm install` (or `pnpm install` or `yarn`), start a development server:

```bash

cp .env.example .env

# configure PUBLIC_API_URL variable 

npm install

npm run dev

# or start the server and open the app in a new browser tab
npm run dev -- --open
```

## Building

To create a production version of your app:

```bash
npm run build
```

You can preview the production build with `npm run preview`.

> To deploy your app, you may need to install an [adapter](https://kit.svelte.dev/docs/adapters) for your target environment.

---

## 🚀 Deploying to Vercel (Free)

1. **Push this Svelte project (this folder) to a new GitHub repository.**
2. **Sign up at [Vercel.com](https://vercel.com/) and click 'New Project'.**
3. **Import your GitHub repo.**
4. **Vercel auto-detects SvelteKit and sets up the build.**
5. **Set environment variables:** Copy from `.env.example` and fill in values in Vercel's dashboard (especially your backend API URL).
6. **Deploy!**

- After deployment, your frontend will be available at a public URL (e.g., `https://your-app.vercel.app`).
- Make sure your API calls point to your Render backend URL (not localhost).
