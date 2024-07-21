import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\nonoichi_count.txt", 'r') as file:
    lines = file.readlines()

nonoichi = int(lines[0].strip())
nonoichi_w1 = int(lines[1].strip())
nonoichi_w2 = int(lines[2].strip())
nonoichi_w3 = int(lines[3].strip())
nonoichi_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [nonoichi_w1, nonoichi_w2, nonoichi_w3, nonoichi_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('野々市市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/nonoichi_graph.png', bbox_inches='tight', pad_inches=0.2)