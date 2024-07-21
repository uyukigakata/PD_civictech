import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\suzu_count.txt", 'r') as file:
    lines = file.readlines()

suzu = int(lines[0].strip())
suzu_w1 = int(lines[1].strip())
suzu_w2 = int(lines[2].strip())
suzu_w3 = int(lines[3].strip())
suzu_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [suzu_w1, suzu_w2, suzu_w3, suzu_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('珠洲市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/suzu_graph.png', bbox_inches='tight', pad_inches=0.2)