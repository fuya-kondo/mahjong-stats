"use client";

import { useEffect, useState } from "react";

type Game = {
  u_game_history_id: number;
  score: number;
  point: number;
  play_date: string;
  user?: { last_name: string; first_name: string };
  direction?: { name: string };
};

export default function Home() {
  const [games, setGames] = useState<Game[]>([]);

  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/games")
      .then((res) => res.json())
      .then((data) => {
        console.log("API Response:", data); // ← デバッグ出力
        setGames(data);
      });
  }, []);

  return (
    <main className="p-6">
      <h1 className="text-xl font-bold mb-4">麻雀成績一覧</h1>
      <table className="table-auto border-collapse border w-full">
        <thead>
          <tr className="bg-gray-100">
            <th className="border px-2 py-1">日時</th>
            <th className="border px-2 py-1">プレイヤー</th>
            <th className="border px-2 py-1">自家</th>
            <th className="border px-2 py-1">スコア</th>
            <th className="border px-2 py-1">ポイント</th>
          </tr>
        </thead>
        <tbody>
          {games.map((g) => (
            <tr key={g.u_game_history_id}>
              <td className="border px-2 py-1">
                {new Date(g.play_date).toLocaleString("ja-JP")}
              </td>
              <td className="border px-2 py-1">
                {g.user ? `${g.user.last_name} ${g.user.first_name}` : "不明"}
              </td>
              <td className="border px-2 py-1">{g.direction?.name ?? "—"}</td>
              <td className="border px-2 py-1">{g.score}</td>
              <td className="border px-2 py-1">{g.point}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </main>
  );
}
