import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\komatu_count.txt", 'r') as file:
    lines = file.readlines()

komatu = int(lines[0].strip())
komatu_w1 = int(lines[1].strip())
komatu_w2 = int(lines[2].strip())
komatu_w3 = int(lines[3].strip())
komatu_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [komatu_w1, komatu_w2, komatu_w3, komatu_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('小松市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/komatu_graph.png', bbox_inches='tight', pad_inches=0.2)