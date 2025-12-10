"use client";

import { useEffect, useState, use } from "react";

const API_BASE = process.env.NEXT_PUBLIC_API_BASE_URL || "http://localhost:8000";

export default function RankingPage({ params }: { params: Promise<{ id: string }> }) {
  // 🚀 params を unwrap
  const { id } = use(params);

  const [rankings, setRankings] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [sort, setSort] = useState("total_point");
  const [order, setOrder] = useState("desc");

  useEffect(() => {
    setLoading(true);
    fetch(`${API_BASE}/api/groups/${id}/ranking?sort=${sort}&order=${order}`)
      .then((res) => res.json())
      .then((data) => setRankings(data.data ?? data ?? []))
      .catch(() => setRankings([]))
      .finally(() => setLoading(false));
  }, [id, sort, order]);

  if (loading) return <p>読み込み中...</p>;

  return (
    <div>
      <h1>ランキング（グループID: {id}）</h1>

      <div className="mb-4">
        <label className="mr-2">並び替え: </label>
        <select value={sort} onChange={(e) => setSort(e.target.value)}>
          <option value="total_point">合計ポイント</option>
          <option value="average_rank">平均順位</option>
          <option value="win_rate">トップ率</option>
        </select>
        <button
          className="ml-2 border px-2"
          onClick={() => setOrder(order === "asc" ? "desc" : "asc")}
        >
          {order === "asc" ? "昇順" : "降順"}
        </button>
      </div>

      <table className="table-auto border-collapse border w-full">
        <thead>
          <tr>
            <th className="border p-2">順位</th>
            <th className="border p-2">名前</th>
            <th className="border p-2">合計ポイント</th>
            <th className="border p-2">平均順位</th>
            <th className="border p-2">トップ率</th>
          </tr>
        </thead>
        <tbody>
          {rankings.length > 0 ? (
            rankings.map((r, idx) => (
              <tr key={r.user_id}>
                <td className="border p-2">{idx + 1}</td>
                <td className="border p-2">{r.user_name}</td>
                <td className="border p-2">{Number(r.total_point).toFixed(1)}</td>
                <td className="border p-2">{Number(r.average_rank).toFixed(2)}</td>
                <td className="border p-2">
                  {(Number(r.win_rate) * 100).toFixed(1)}%
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan={5} className="border p-2 text-center">
                データがありません
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}
