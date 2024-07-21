import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\noubi_count.txt", 'r') as file:
    lines = file.readlines()

noubi = int(lines[0].strip())
noubi_w1 = int(lines[1].strip())
noubi_w2 = int(lines[2].strip())
noubi_w3 = int(lines[3].strip())
noubi_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [noubi_w1, noubi_w2, noubi_w3, noubi_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('能美市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/noubi_graph.png', bbox_inches='tight', pad_inches=0.2)
