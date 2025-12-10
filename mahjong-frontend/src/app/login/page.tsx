"use client";

import { useState } from "react";
import apiClient, { setAuthToken } from "@/lib/apiClient";

export default function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);

  const handleLogin = async () => {
    try {
      setLoading(true);
      const res = await apiClient.post("/login", { email, password });
      const token = res.data.token;

      setAuthToken(token);
      localStorage.setItem("token", token);

      alert("ログイン成功！");
    } catch (error) {
      alert("ログイン失敗");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="p-6 max-w-sm mx-auto">
      <h1 className="text-xl font-bold mb-4">ログイン</h1>

      <input
        type="email"
        placeholder="メールアドレス"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        className="border p-2 mb-2 block w-full"
      />

      <input
        type="password"
        placeholder="パスワード"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
        className="border p-2 mb-2 block w-full"
      />

      <button
        onClick={handleLogin}
        className="bg-blue-500 text-white px-4 py-2 rounded w-full"
        disabled={loading}
      >
        {loading ? "ログイン中..." : "ログイン"}
      </button>
    </div>
  );
}
