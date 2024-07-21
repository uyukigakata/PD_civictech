import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\sirayama_count.txt", 'r') as file:
    lines = file.readlines()

sirayama = int(lines[0].strip())
sirayama_w1 = int(lines[1].strip())
sirayama_w2 = int(lines[2].strip())
sirayama_w3 = int(lines[3].strip())
sirayama_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [sirayama_w1, sirayama_w2, sirayama_w3, sirayama_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('白山市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/sirayama_graph.png', bbox_inches='tight', pad_inches=0.2)