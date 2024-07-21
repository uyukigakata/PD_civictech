import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\kahoku_count.txt", 'r') as file:
    lines = file.readlines()

kahoku = int(lines[0].strip())
kahoku_w1 = int(lines[1].strip())
kahoku_w2 = int(lines[2].strip())
kahoku_w3 = int(lines[3].strip())
kahoku_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [kahoku_w1, kahoku_w2, kahoku_w3, kahoku_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('かほく市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/kahoku_graph.png', bbox_inches='tight', pad_inches=0.2)