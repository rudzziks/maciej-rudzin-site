# 🔥 Maciej Rudzin - Personal Space 🔥

## Deployment Instructions for Netlify

### Step 1: Get Anthropic API Key

1. Go to https://console.anthropic.com/
2. Sign up or log in
3. Go to "API Keys" section
4. Create a new API key
5. Copy the key (starts with `sk-ant-...`)

### Step 2: Deploy to Netlify

#### Option A: Drag & Drop (Easiest)

1. Go to https://app.netlify.com/drop
2. Drag ALL files from this folder into the drop zone
3. Wait for deployment to complete
4. Click on "Site settings"
5. Go to "Environment variables"
6. Add new variable:
   - **Key**: `ANTHROPIC_API_KEY`
   - **Value**: Your API key from Step 1
7. Go to "Deploys" and click "Trigger deploy" → "Clear cache and deploy site"
8. Done! Your site is live! 🎉

#### Option B: GitHub (Recommended for updates)

1. Create a new GitHub repository
2. Upload all these files to the repo
3. Go to https://app.netlify.com/
4. Click "Add new site" → "Import an existing project"
5. Choose GitHub and select your repo
6. Netlify will auto-detect settings
7. Before deploying, add environment variable:
   - Go to "Site configuration" → "Environment variables"
   - Add `ANTHROPIC_API_KEY` with your key
8. Deploy!

### Step 3: Test

1. Visit your site URL (e.g., `your-site-name.netlify.app`)
2. Try chatting with the Rudzin_BOT
3. If it works - you're done! 🎉
4. If you get errors, check:
   - Environment variable is set correctly
   - API key is valid
   - Check Netlify Function logs in dashboard

### Files Structure

```
/
├── index.html              # Main chat page (was level1.html)
├── desktop.html            # Future: Your desktop page
├── netlify.toml           # Netlify configuration
├── netlify/functions/
│   └── chat.js            # Serverless function (hides API key)
└── README-DEPLOY.md       # This file
```

### Environment Variables Needed

- `ANTHROPIC_API_KEY` - Your Anthropic API key (REQUIRED)

### Cost

- **Netlify**: Free tier includes 125k function requests/month
- **Anthropic API**: Pay per token used
  - Claude Sonnet 4: ~$3 per million input tokens
  - For casual chat: probably < $1/month

### Troubleshooting

**"API key not configured" error:**
- Make sure you added `ANTHROPIC_API_KEY` in Netlify environment variables
- Redeploy after adding the variable

**"Connection unstable" error:**
- Check browser console (F12) for detailed errors
- Check Netlify Function logs in your dashboard
- Make sure API key is valid

**Chat not responding:**
- Check Netlify Function logs
- Make sure you didn't exceed API rate limits
- Verify API key has credits

### Security Notes

✅ **SAFE**: API key is stored in Netlify environment variables (server-side)
✅ **SAFE**: Netlify Function acts as proxy - visitors never see your key
❌ **DON'T**: Never put API key directly in HTML/JavaScript files

### Next Steps

After deployment works:
1. Create `desktop.html` - your personal desktop with folders/files
2. Add your content (memories, films, music)
3. Customize the chat prompt in `index.html`
4. Add custom domain (optional)

---

Need help? Check:
- Netlify docs: https://docs.netlify.com/functions/overview/
- Anthropic API docs: https://docs.anthropic.com/

Good luck! 🚀
