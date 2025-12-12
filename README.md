# 麻雀成績管理サイト（Laravel + React/Next.js / AWS）  
※開発中

家族・友人間で利用する麻雀成績管理サービスを、既存版（PHP/JS）からフルリプレイスするプロジェクトです。  
バックエンドを Laravel、フロントエンドを React/Next.js、インフラを AWS へ移行し、拡張性・保守性・パフォーマンスを向上させることを目的としています。

---

## 目的
- 既存サービスのコードベースを刷新し、可読性と拡張性を向上
- 成績集計ロジックとデータモデルの再整理および API 化
- Next.js による UI の全面リニューアル
- AWS での安定稼働を想定した構成へ移行
- 将来的な機能拡張

---

## 技術スタック（予定）

### バックエンド
- Laravel 11 
- PHP 8.x  

### フロントエンド
- React  
- Next.js 15  
- TypeScript  
- Zustand / Redux Toolkit（予定）

### インフラ
- AWS（予定構成）
  - API: AWS Fargate / ECS  
  - Web: Amplify または S3 + CloudFront  
  - DB: Amazon RDS  
  - CI/CD: GitHub Actions  
  - Auth: Cognito（検討）

---

## リプレイス元（既存サービス）
現行稼働中のバージョンはこちら  
https://github.com/fuya-kondo/aisai_m_league

技術構成:
- バックエンド: PHP  
- フロント: JavaScript, HTML, CSS  
- DB: MySQL  
- 本番環境: Xserver  
- 主な機能: 成績登録、全体成績、個人成績、称号、Tier、管理画面 等

UI のイメージや既存機能は上記リポジトリ README を参照。

---

