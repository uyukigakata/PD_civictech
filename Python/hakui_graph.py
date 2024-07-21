import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\hakui_count.txt", 'r') as file:
    lines = file.readlines()

hakui = int(lines[0].strip())
hakui_w1 = int(lines[1].strip())
hakui_w2 = int(lines[2].strip())
hakui_w3 = int(lines[3].strip())
hakui_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [hakui_w1, hakui_w2, hakui_w3, hakui_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('羽咋市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/hakui_graph.png', bbox_inches='tight', pad_inches=0.2)