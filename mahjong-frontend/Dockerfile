# Node.js イメージを使用
FROM node:20-alpine

# 作業ディレクトリを作成
WORKDIR /app

# package.json と lock ファイルだけコピーして依存関係を先にインストール
COPY package*.json ./

RUN npm install

# ソースコードをコピー
COPY . .

# Next.js のポートを開放
EXPOSE 3000

# 開発用コマンド（docker-compose.yml で上書きも可）
CMD ["npm", "run", "dev"]
