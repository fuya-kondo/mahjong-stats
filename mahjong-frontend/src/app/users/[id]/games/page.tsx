"use client";

import { useEffect, useState } from "react";
import { useParams } from "next/navigation";
import apiClient, { setAuthToken } from "@/lib/apiClient";

interface Game {
    game_id: number;
    rank: string;
    score: number;
    point: number;
    date: string;
    group_name: string | null;
}


export default function UserGamesPage() {
    const params = useParams();
    const userId = params?.id;

    const [games, setGames] = useState<Game[]>([]);
    const [page, setPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);
    const [loading, setLoading] = useState(false);

    const fetchGames = async (pageNum: number) => {
        try {
        setLoading(true);
        const token = localStorage.getItem("token");
        setAuthToken(token);

        const res = await apiClient.get(`/users/${userId}/games?page=${pageNum}`);
        setGames(res.data.data);
        setPage(res.data.meta.current_page);
        setLastPage(res.data.meta.last_page);
        } catch (err) {
        console.error("試合履歴の取得に失敗しました", err);
        } finally {
        setLoading(false);
        }
    };

    useEffect(() => {
        if (userId) fetchGames(1);
    }, [userId]);

    // 日付を日本形式に変換
    const formatDate = (dateStr: string) => {
        return new Intl.DateTimeFormat("ja-JP", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        }).format(new Date(dateStr));
    };

    // 順位の色分け
    const getRankColor = (rank: string) => {
        switch (rank) {
        case "1":
            return "text-green-600 font-bold";
        case "2":
            return "text-blue-600";
        case "3":
            return "text-orange-500";
        case "4":
            return "text-red-600 font-bold";
        default:
            return "";
        }
    };

    return (
        <div className="bg-gray-50 min-h-screen p-4">
        <div className="max-w-3xl mx-auto">
            <h1 className="text-2xl font-bold mb-6">
            ユーザー {userId} の試合履歴
            </h1>

            {loading && <p>読み込み中...</p>}

            {/* PC用テーブル */}
            <div className="hidden sm:block">
            <table className="border-collapse border border-gray-300 w-full text-sm bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr className="bg-gray-100 text-left">
                    <th className="border p-2">順位</th>
                    <th className="border p-2">スコア</th>
                    <th className="border p-2">ポイント</th>
                    <th className="border p-2">日時</th>
                    <th className="border p-2">グループ</th>
                </tr>
                </thead>
                <tbody>
                {games.map((g) => (
                    <tr key={g.game_id} className="hover:bg-gray-50">
                    <td className={`border p-2 ${getRankColor(g.rank)}`}>{g.rank}</td>
                    <td className="border p-2">{g.score.toLocaleString()}</td>
                    <td className="border p-2">{g.point != null ? Number(g.point).toFixed(1) : "-"}</td>
                    <td className="border p-2">{formatDate(g.date)}</td>
                    <td className="border p-2">{g.group_name ?? "-"}</td>
                    </tr>
                ))}
                </tbody>
            </table>
            </div>

            {/* スマホ用カード */}
            <div className="space-y-3 sm:hidden">
                {games.map((g) => (
                    <div
                    key={g.game_id}
                    className="bg-white p-4 rounded-lg shadow border border-gray-200"
                    >
                    <p className={`text-lg ${getRankColor(g.rank)}`}>
                        順位: {g.rank}
                    </p>
                    <p className="text-sm">スコア: {g.score.toLocaleString()} 点</p>
                    <p className="text-sm">ポイント: {g.point != null ? Number(g.point).toFixed(1) : "-"}</p>
                    <p className="text-sm text-gray-500">{formatDate(g.date)}</p>
                    <p className="text-sm text-gray-500">グループ: {g.group_name ?? "-"}</p>
                    </div>
                ))}
            </div>

            {/* ページネーション */}
            <div className="flex justify-between items-center mt-6">
            <button
                onClick={() => fetchGames(page - 1)}
                disabled={page <= 1}
                className="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
            >
                前へ
            </button>
            <span>
                {page} / {lastPage}
            </span>
            <button
                onClick={() => fetchGames(page + 1)}
                disabled={page >= lastPage}
                className="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
            >
                次へ
            </button>
            </div>
        </div>
        </div>
    );
}
